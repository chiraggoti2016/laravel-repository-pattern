<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\CpuCount;
use App\Models\Hostname;
use App\Models\CpuCountDetail;
use App\Models\CpuCountDiskDetail;
use App\Models\CpuCountMemoryDetail;
use App\Models\CpuCountStorageDetail;
use App\Models\CpuCountDatabaseDetail;
use Storage;
use DB;

class CpuCountController extends Controller
{
    //
    public function index(Request $request, $slug) {        
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:txt' 
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            //return back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();

            $project  = Project::where('slug', $slug)->first();

            $filename  = $request->file->getClientOriginalName();
            $extension = $request->file->getClientOriginalExtension();

            $file = Storage::disk('public')->put('cpu-count/'.$project->folder, $request->file);

            $path = Storage::disk('public')->path($file);

            $newfile  = explode('/', $file)[2];

            $sections = $this->getCpuUsage($path);
            
            $file_type = trim($sections[0][0]);
            if($file_type == "CPU_COUNT") {
                $cpu = $this->cpu_count($sections, $project, $filename, $newfile, $file);
                if($cpu == true) {
                    dump('All good.');
                    DB::commit();
                } else {
                    dd('Something sent wrong!');
                }
            } else {
                dd('Invalid file data.');
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getcpuusage($path) {
        define("_EMPTY", "");
        define("_VSP", "_VSP");
        define("_HSP", "_HSP");
        define("_SP_COLON", ":");
        define("_SP_SPACE", " ");
        define("_TYPE", "_TYPE");
        define("_TYPE_V", "V");
        define("_TYPE_H", "H");
        define("_TYPE_VH", "VH");

        // section type
        // SP = splitor 
        // TYPE V-vertical H-horizontal 
        $sectionType = [
            // section 1
            [ _TYPE => _EMPTY ],
            // section 2
            [ _TYPE => _EMPTY ],
            // section 3
            [ _TYPE => _EMPTY ],
            // section 4
            [ _TYPE => _TYPE_V, _VSP => _SP_COLON ],
            // section 5
            [ _TYPE => _EMPTY ],
            [ _TYPE => _TYPE_VH, _VSP => _SP_COLON, _HSP => _SP_SPACE ],
            // section 6
            [ _TYPE => _EMPTY ],
            // section 7
            [ _TYPE => _EMPTY ],
            // section 8
            [ _TYPE => _TYPE_H, _HSP => _SP_SPACE ],
            // section 9
            [ _TYPE => _EMPTY ],
        ];

        // sectionSplitor 
        $sectionSp = '#';
        $sections = [];
        $sectionIndex = 0;
        $tableIndex = 0;
        $tableColumns = [];
        
        if ($file = fopen($path, "r")) {
            while(!feof($file)) {
                $line = fgets($file);
                if( preg_match("/(#{45,})/i", $line) ) {
                    $sectionIndex++;
                    $tableIndex=0;
                    $tableColumns = [];
                    continue;
                }
                if( $sectionIndex >= 9) {
                    break;
                }
                if( empty($line) || preg_replace("/\s+/","", $line) === "" ) {
                    continue;
                }

                // do your action:start
                $type = $sectionType[$sectionIndex];
                if($type[_TYPE] === _EMPTY) {
                    $sections[$sectionIndex][$tableIndex]=$line;
                } else {
                    $line = preg_replace("/\s+/"," ", $line);
                    $line = trim($line);
                    // Vertical spliting
                    if($type[_TYPE] === _TYPE_V) {
                        $arr = explode($type[_VSP], $line);
                        if(count($arr) > 0) {
                            $sections[$sectionIndex][ $arr[0] ] = $arr[1];
                        }
                    } elseif($type[_TYPE] === _TYPE_H) { // Horizontal spilting
                        // _SP_SPACE
                        if ($tableIndex === 0) {
                            $columns = explode($type[_HSP], $line);
                            $tableColumns = $columns;
                        } else {
                            $values = explode($type[_HSP], $line);
                            if(count($values) > 0) {
                                $row = [];
                                foreach($tableColumns as $index => $column) {
                                    $row[$column] = isset($values[$index]) ? $values[$index] : "";
                                }
                                $sections[$sectionIndex][ ] = $row;
                            }
                        }
                    } elseif($type[_TYPE] === _TYPE_VH) {
                        // make section 1st row as columns
                        if ($tableIndex === 0) {
                            $columns = explode($type[_HSP], $line);
                            $tableColumns = $columns;
                        } else {
                            $arr = explode($type[_VSP], $line);
                            if(count($arr) > 0 && isset($arr[0]) && isset($arr[1])) {
                                $subline = trim($arr[1]);
                                $row = [];
                                $values = explode($type[_HSP], $subline);
                                foreach($tableColumns as $index => $column) {
                                    $row[$column] = isset($values[$index]) ? $values[$index] : "";
                                }
                                $sections[$sectionIndex][ $arr[0] ] = $row;
                            }
                        }
                    }
                }
                // do your action:end
                $tableIndex++;
            }

            fclose($file);
        }

        return $sections;
    }

    public function cpu_count($sections, $project, $filename, $newfile, $file) {
        // CPU Info
        $hostname = trim($sections[1][0]);
        if(isset($hostname) && $hostname != '') {
            // #1 Hostname
            $hostname = Hostname::where('project_id', $project->id)->where('hostname', $hostname)->first();
            if(isset($hostname) && $hostname != '') {
            } else {
                $hostname = new Hostname();
            }
            $hostname->project_id          = $project->id;
            $hostname->hostname            = trim($sections[1][0]);
            $hostname->cpu_count_file      = $filename;
            $hostname->cpu_count_new_file  = $newfile;
            $hostname->cpu_count_file_path = $file;
            $hostname->cpu_count_date      = date('Y-m-d');
            $hostname->save();

            // #2 CPU Count
            if(isset($sections[1][1]) && $sections[1][1] != '') {
                $os_explode = explode(" ", $sections[1][1]);
                $os = $os_explode[0];
                $kernel = $os_explode[2];
                $user_input = $sections[2][0];

                if(isset($os) && isset($kernel) && isset($user_input)) {
                    CpuCount::where('project_id', $project->id)->where('hostname_id', $hostname->id)->delete();
                    $cpu_count = new CpuCount();
                    $cpu_count->project_id     = $project->id;
                    $cpu_count->hostname_id    = $hostname->id;
                    $cpu_count->hostname       = $hostname->hostname;
                    $cpu_count->os             = $os;
                    $cpu_count->kernel_version = $kernel;
                    $cpu_count->user_input     = $user_input;
                    $cpu_count->save();
                }
            }

            // #3 CPU Details
            $cpudetails = $sections[3];
            if(!empty($cpudetails) && count($cpudetails) > 0) {
                CpuCountDetail::where('project_id', $project->id)->where('hostname_id', $hostname->id)->delete();

                $architecture=$cpu_op_mode=$byte_order=$cpu=$on_line_cpu_list=$thread_per_core=$core_per_socket=$socket=$numa_node=$vendor_id=$cpu_family=$model=$model_name=$stepping=$cpu_mhz=$cpu_max_mhz=$cpu_min_mhz=$bogo_mips=$hypervisor_vendor=$virtualization=$virtualization_type=$l1d_cache=$l1i_cache=$l2_cache=$l3_cache=$numa_node0_cpu=$numa_node1_cpu=$flags=NULL;
                $cpu_count_detail = new CpuCountDetail();
                $cpu_count_detail->project_id   = $project->id;
                $cpu_count_detail->hostname_id  = $hostname->id;
                $cpu_count_detail->cpu_count_id = $cpu_count->id;
                foreach($cpudetails as $key => $value) {
                    if($key == 'Architecture') {
                        $cpu_count_detail->architecture = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'CPU op-mode(s)') {
                        $cpu_count_detail->op_modes = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'Byte Order') {
                        $cpu_count_detail->byte_order = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'CPU(s)') {
                        $cpu_count_detail->cpus = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'On-line CPU(s) list') {
                        $cpu_count_detail->on_line_cpus_list = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'Thread(s) per core') {
                        $cpu_count_detail->threads_per_core = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'Core(s) per socket') {
                        $cpu_count_detail->cores_per_socket =  (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'Socket(s)') {
                        $cpu_count_detail->sockets = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'NUMA node(s)') {
                        $cpu_count_detail->numa_nodes = (isset($value) && $value != '') ? $value : NULL; 
                    } elseif($key == 'Vendor ID') {
                        $cpu_count_detail->vendor_id = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'CPU family') {
                        $cpu_count_detail->cpu_family = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'Model') {
                        $cpu_count_detail->model = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'Model name') {
                        $cpu_count_detail->model_name = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'Stepping') {
                        $cpu_count_detail->stepping = (isset($value) && $value != '') ? $value : NULL; 
                    } elseif($key == 'CPU MHz') {
                        $cpu_count_detail->cpu_mhz = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'CPU max MHz') {
                        $cpu_count_detail->cpu_max_mhz = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'CPU min MHz') {
                        $cpu_count_detail->cpu_min_mhz = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'BogoMIPS') {
                        $cpu_count_detail->bogo_mips = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'Virtualization') {
                        $cpu_count_detail->virtualization = (isset($value) && $value != '') ? $value : null;
                    } elseif($key == 'Hypervisor vendor') {
                        $cpu_count_detail->hypervisor_vendor = (isset($value) && $value != '') ? $value : null;
                    } elseif($key == 'Virtualization type') {
                        $cpu_count_detail->virtualization_type = (isset($value) && $value != '') ? $value : null;
                    } elseif($key == 'L1d cache') {
                        $cpu_count_detail->l1d_cache = (isset($value) && $value != '') ? $value : null;
                    } elseif($key == 'L1i cache') {
                        $cpu_count_detail->l1i_cache = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'L2 cache') {
                        $cpu_count_detail->l2_cache = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'L3 cache') {
                        $cpu_count_detail->l3_cache = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'NUMA node0 CPU(s)') {
                        $cpu_count_detail->numa_node0_cpus = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'NUMA node1 CPU(s)') {
                        $cpu_count_detail->numa_node1_cpus = (isset($value) && $value != '') ? $value : NULL;
                    } elseif($key == 'Flags') {
                        $cpu_count_detail->flags = (isset($value) && $value != '') ? $value : NULL;
                    }
                }
                $cpu_count_detail->save();
            }

            // #4 Memory Details
            $memory_details = $sections[5];
            if(!empty($memory_details) && count($memory_details) > 0) {
                CpuCountMemoryDetail::where('project_id', $project->id)->where('hostname_id', $hostname->id)->delete();

                foreach($memory_details as $key => $memory_detail) {
                    if(isset($key) && $key == 'Mem') {
                        $cpu_count_memory_detail = new CpuCountMemoryDetail();
                        $cpu_count_memory_detail->project_id   = $project->id;
                        $cpu_count_memory_detail->hostname_id  = $hostname->id;
                        $cpu_count_memory_detail->cpu_count_id = $cpu_count->id;
                        $cpu_count_memory_detail->memory_type  = 'Mem';
                        $cpu_count_memory_detail->total        = $memory_detail['total'];
                        $cpu_count_memory_detail->used         = $memory_detail['used'];
                        $cpu_count_memory_detail->free         = (isset($memory_detail['free']) && $memory_detail['free'] != '') ? $memory_detail['free'] : 0;
                        $cpu_count_memory_detail->shared       = (isset($memory_detail['shared']) && $memory_detail['shared'] != '') ? $memory_detail['shared'] : 0;
                        $cpu_count_memory_detail->buffers      = (isset($memory_detail['buff/cache']) && $memory_detail['buff/cache'] != '') ? $memory_detail['buff/cache'] : 0;
                        $cpu_count_memory_detail->cached       = (isset($memory_detail['available']) && $memory_detail['available'] != '') ? $memory_detail['available'] : 0;
                        $cpu_count_memory_detail->save();
                    }
                    if(isset($key) && $key == 'Swap') { 
                        $cpu_count_memory_detail = new CpuCountMemoryDetail();
                        $cpu_count_memory_detail->project_id   = $project->id;
                        $cpu_count_memory_detail->hostname_id  = $hostname->id;
                        $cpu_count_memory_detail->cpu_count_id = $cpu_count->id;
                        $cpu_count_memory_detail->memory_type  = 'Swap';
                        $cpu_count_memory_detail->total        = $memory_detail['total'];
                        $cpu_count_memory_detail->used         = $memory_detail['used'];
                        $cpu_count_memory_detail->free         = (isset($memory_detail['free']) && $memory_detail['free'] != '') ? $memory_detail['free'] : 0;
                        $cpu_count_memory_detail->shared       = (isset($memory_detail['shared']) && $memory_detail['shared'] != '') ? $memory_detail['shared'] : 0;
                        $cpu_count_memory_detail->buffers      = (isset($memory_detail['buff/cache']) && $memory_detail['buff/cache'] != '') ? $memory_detail['buff/cache'] : 0;
                        $cpu_count_memory_detail->cached       = (isset($memory_detail['available']) && $memory_detail['available'] != '') ? $memory_detail['available'] : 0;
                        $cpu_count_memory_detail->save();
                    }
                }
            }

            // #5 Disk Details
            if(!empty($sections[7]) && $sections[7] != '') {
                CpuCountDatabaseDetail::where('project_id', $project->id)->where('hostname_id', $hostname->id)->delete();
                $database_details = $sections[7];

                foreach($database_details as $database_detail) {
                    $username = explode(" ", $database_detail); 
                    $ora_smon = explode("ora_smon_", $database_detail);
                    if(isset($ora_smon[1]) && $ora_smon[1] != '') {
                        $cpu_count_db_detail = new CpuCountDatabaseDetail();
                        $cpu_count_db_detail->project_id   = $project->id;
                        $cpu_count_db_detail->hostname_id  = $hostname->id;
                        $cpu_count_db_detail->cpu_count_id = $cpu_count->id;
                        $cpu_count_db_detail->user         = $username[0];
                        $cpu_count_db_detail->db_name      = trim($ora_smon[1]);
                        $cpu_count_db_detail->db_type      = 'ora';
                        $cpu_count_db_detail->save();
                    }
                    $asm_smon = explode("asm_smon_", $database_detail);
                    if(isset($asm_smon[1]) && $asm_smon[1] != '') {
                        $cpu_count_db_detail = new CpuCountDatabaseDetail();
                        $cpu_count_db_detail->project_id   = $project->id;
                        $cpu_count_db_detail->hostname_id  = $hostname->id;
                        $cpu_count_db_detail->cpu_count_id = $cpu_count->id;
                        $cpu_count_db_detail->user         = $username[0];
                        $cpu_count_db_detail->db_name      = trim($asm_smon[1]);
                        $cpu_count_db_detail->db_type      = 'asm';
                        $cpu_count_db_detail->save();
                    }
                }
            }

            // #6 Storage Details
            if(!empty($sections[8]) && $sections[8] != '') {
                $storage_details = $sections[8];
                CpuCountStorageDetail::where('project_id', $project->id)->where('hostname_id', $hostname->id)->delete();
                foreach($storage_details as $storage_detail) {
                    $cpu_count_storage_detail = new CpuCountStorageDetail();
                    $cpu_count_storage_detail->project_id    = $project->id;
                    $cpu_count_storage_detail->hostname_id    = $hostname->id;
                    $cpu_count_storage_detail->cpu_count_id   = $cpu_count->id;
                    $cpu_count_storage_detail->file_system    = $storage_detail['Filesystem'];
                    $cpu_count_storage_detail->size           = $storage_detail['Size'];
                    $cpu_count_storage_detail->used           = $storage_detail['Used'];
                    $cpu_count_storage_detail->avail          = $storage_detail['Avail'];
                    $cpu_count_storage_detail->use_percentage = $storage_detail['Use%'];
                    $cpu_count_storage_detail->mounted_on     = $storage_detail['Mounted'];
                    $cpu_count_storage_detail->save();
                }
            }
            
            // #7 Memory Details
            /*if(!empty($sections[8]) && $sections[8] != '') {
                $disk_details = $sections[8];
                $cpu_count_disk_detail = new CpuCountDiskDetail();
                $cpu_count_disk_detail->cpu_count_id = $cpu_count->id;
                $cpu_count_disk_detail->name         =
                $cpu_count_disk_detail->size         =
                $cpu_count_disk_detail->save();
            }*/

            return true;
        } else {
            return false;
        }
    }
}
