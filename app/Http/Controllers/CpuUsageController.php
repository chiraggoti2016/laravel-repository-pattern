<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsageDatabase;
use App\Models\UsageKbmemfree;
use App\Models\UsageKbswpfree;
use App\Models\UsageProc;
use App\Models\UsagePswpin;
use App\Models\UsagePgpgin;
use App\Models\UsageTps;
use App\Models\UsageFrmpg;
use App\Models\UsageKbhugfree;
use App\Models\UsageDentunusd;
use App\Models\UsageRunqsz;
use App\Models\UsageTty;
use App\Models\UsageDev;
use App\Models\UsageCalls;
use App\Models\UsageScalls;
use App\Models\UsageTotsck;
use App\Models\Hostname;
use App\Models\Project;
use Storage;
use DB;

class CpuUsageController extends Controller
{
    //
    public function index(Request $request, $slug) {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:txt|max:100000' 
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();

            $project = Project::where('slug', $slug)->first();
            
            $filename  = $request->file->getClientOriginalName();
            $extension = $request->file->getClientOriginalExtension();

            $file = Storage::disk('public')->put('cpu-usage/'.$project->folder, $request->file);

            $path = Storage::disk('public')->path($file);

            $newfile  = explode('/', $file)[2];

            $sections = $this->getCpuUsage($path);
            
            if(isset($sections['file']) && $sections['file'] == "CPU_USAGE") {
                if(!empty($sections['final_array']) && count($sections['final_array']) > 0) {
                    $cpu = $this->cpuusage($sections['final_array'], $project, $filename, $newfile, $file, $sections['hostname']);
                    dump('All good.');
                    DB::commit();   
                } else {
                    dd('Invalid data');
                }
            } else {
                dd('Invalide file data.');
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cpuusage($sections, $project, $filename, $newfile, $file, $hostname) {
        $host_name = trim($hostname);
        if(isset($host_name) && $host_name != '') {
            $hostname = Hostname::where('project_id', $project->id)->where('hostname', trim($hostname))->first();

            if(isset($hostname) && $hostname != '') {
            } else {
                $hostname = new Hostname();
            }
            $hostname->project_id          = $project->id;
            $hostname->hostname            = $host_name;
            $hostname->cpu_usage_file      = $filename;
            $hostname->cpu_usage_new_file  = $newfile;
            $hostname->cpu_usage_file_path = $file;
            $hostname->cpu_usage_date      = date('Y-m-d');
            $hostname->save();

            UsageDatabase::where('hostname_id', $hostname->id)->where('project_id', $project->id)->delete();
            UsageProc::where('hostname_id', $hostname->id)->where('project_id', $project->id)->delete();
            UsagePswpin::where('hostname_id', $hostname->id)->where('project_id', $project->id)->delete();
            UsagePgpgin::where('hostname_id', $hostname->id)->where('project_id', $project->id)->delete();
            UsageTps::where('hostname_id', $hostname->id)->where('project_id', $project->id)->delete();
            UsageFrmpg::where('hostname_id', $hostname->id)->where('project_id', $project->id)->delete();
            UsageKbmemfree::where('hostname_id', $hostname->id)->where('project_id', $project->id)->delete();
            UsageKbswpfree::where('hostname_id', $hostname->id)->where('project_id', $project->id)->delete();
            
            foreach($sections as $key => $value) {
                $date = str_replace('/', '-', $key);
                $date = date("Y-m-d", strtotime($date));
                foreach($value as $key => $val) {
                    if($key == 'cpu') {
                        $cpu_database = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode("   ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$cpu_database['key'] = $array;
                            } else {
                                $cpu_database[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($cpu_database) && count($cpu_database) > 0) {
                            $this->saveCpuUsageDatabase($cpu_database, $date, $hostname);
                        }
                    }
                    if($key == 'proc/s') {
                        $procs = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$procs['key'] = $array;
                            } else {
                                $procs[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($procs) && count($procs) > 0) {
                            $this->saveCpuUsageProcs($procs, $date, $hostname);
                        }
                    }
                    if($key == 'pswpin/s') {
                        $pswpins = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$pswpins['key'] = $array;
                            } else {
                                $pswpins[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($pswpins) && count($pswpins) > 0) {
                            $this->saveCpuUsagePswpins($pswpins, $date, $hostname);
                        }
                    }
                    if($key == 'pgpgin/s') {
                        $pgpgins = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$pgpgins['key'] = $array;
                            } else {
                                $pgpgins[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($pgpgins) && count($pgpgins) > 0) {
                            $this->saveCpuUsagePgpgins($pgpgins, $date, $hostname);
                        }
                    }
                    if($key == 'tps') {
                        $tps = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$tps['key'] = $array;
                            } else {
                                $tps[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($tps) && count($tps) > 0) {
                            $this->saveCpuUsageTps($tps, $date, $hostname);
                        }
                    }
                    if($key == 'frmpg/s') {
                        $frmpg = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$frmpg['key'] = $array;
                            } else {
                                $frmpg[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($frmpg) && count($frmpg) > 0) {
                            $this->saveCpuUsageFrmpg($frmpg, $date, $hostname);
                        }
                    }
                    if($key == 'kbmemfree') {
                        $kbmemfree = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$kbmemfree['key'] = $array;
                            } else {
                                $kbmemfree[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($kbmemfree) && count($kbmemfree) > 0) {
                            $this->saveCpuUsageKbmemfree($kbmemfree, $date, $hostname);
                        }
                    }
                    if($key == 'kbswpfree') {
                        $kbswpfree = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$kbswpfree['key'] = $array;
                            } else {
                                $kbswpfree[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($kbswpfree) && count($kbswpfree) > 0) {
                            $this->saveCpuUsageKbswpfree($kbswpfree, $date, $hostname);
                        }
                    }
                    if($key == 'kbhugfree') {
                        $kbhugfree = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$kbhugfree['key'] = $array;
                            } else {
                                $kbhugfree[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($kbhugfree) && count($kbhugfree) > 0) {
                            $this->saveCpuUsageKbhugfree($kbhugfree, $date, $hostname);
                        }
                    }
                    if($key == 'dentunusd') {
                        $dentunusd = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$dentunusd['key'] = $array;
                            } else {
                                $dentunusd[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($dentunusd) && count($dentunusd) > 0) {
                            $this->saveCpuUsageDentunusd($dentunusd, $date, $hostname);
                        }
                    }
                    if($key == 'runq-sz') {
                        $runqsz = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$runqsz['key'] = $array;
                            } else {
                                $runqsz[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($runqsz) && count($runqsz) > 0) {
                            $this->saveCpuUsageRunqsz($runqsz, $date, $hostname);
                        }
                    }
                    if($key == 'TTY') {
                        $tty = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$tty['key'] = $array;
                            } else {
                                $tty[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($tty) && count($tty) > 0) {
                            $this->saveCpuUsageTty($tty, $date, $hostname);
                        }
                    }
                    if($key == 'DEV') {
                        $dev = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$dev['key'] = $array;
                            } else {
                                $dev[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($dev) && count($dev) > 0) {
                            $this->saveCpuUsageDev($dev, $date, $hostname);
                        }
                    }
                    /*if($key == 'IFACE') {
                        $iface = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$iface['key'] = $array;
                            } else {
                                $iface[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($iface) && count($iface) > 0) {
                            $this->saveCpuUsageIface($iface, $date, $hostname);
                        }
                    }*/
                    if($key == 'call/s') {
                        $calls = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$calls['key'] = $array;
                            } else {
                                $calls[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($calls) && count($calls) > 0) {
                            $this->saveCpuUsageCalls($calls, $date, $hostname);
                        }
                    }
                    if($key == 'scall/s') {
                        $scalls = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$scalls['key'] = $array;
                            } else {
                                $scalls[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($scalls) && count($scalls) > 0) {
                            $this->saveCpuUsageScalls($scalls, $date, $hostname);
                        }
                    }
                    if($key == 'totsck') {
                        $totsck = [];
                        $index = 0;
                        foreach($val as $key => $val) {
                            $datas = explode(" ", $val);
                            $array = [];
                            foreach($datas as $data) {
                                $line = trim($data);
                                if(isset($line) && trim($data) != '') {
                                    array_push($array, $line); 
                                }
                            }
                            if($index == 0) {
                                //$totsck['key'] = $array;
                            } else {
                                $totsck[$index] = $array;
                            }
                            $index++;
                        }
                        if(!empty($totsck) && count($totsck) > 0) {
                            $this->saveCpuUsageTotsck($totsck, $date, $hostname);
                        }
                    }
                }
            }
        } else {
            return false;
        }
    }

    public function saveCpuUsageDatabase($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_db = new UsageDatabase();
            $usage_db->hostname_id = $hostname->id;
            $usage_db->project_id  = $hostname->project_id;
            $usage_db->hostname    = $hostname->hostname;
            $usage_db->cpu         = $section[1];
            $usage_db->usr         = $section[2];
            $usage_db->nice        = $section[3];
            $usage_db->sys         = $section[4];
            $usage_db->iowait      = $section[5];
            $usage_db->steal       = $section[6];
            $usage_db->irq         = $section[7];
            $usage_db->soft        = $section[8];
            $usage_db->guest       = $section[9];
            $usage_db->gnice       = $section[10];
            $usage_db->idle        = (isset($section[11]) && $section[11] != '') ? $section[11] : '0.00';
            $usage_db->date        = $date;
            $usage_db->save();
        }
    }

    public function saveCpuUsageProcs($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_proc = new UsageProc();
            $usage_proc->hostname_id = $hostname->id;
            $usage_proc->project_id  = $hostname->project_id;
            $usage_proc->hostname    = $hostname->hostname;
            $usage_proc->proc_s      = $section[1];
            $usage_proc->cswch_s     = $section[2];
            $usage_proc->date        = $date;
            $usage_proc->save();
        }
    }

    public function saveCpuUsagePswpins($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_proc = new UsagePswpin();
            $usage_proc->hostname_id = $hostname->id;
            $usage_proc->project_id  = $hostname->project_id;
            $usage_proc->hostname    = $hostname->hostname;
            $usage_proc->pswpin_s    = $section[1];
            $usage_proc->pswpout_s   = $section[2];
            $usage_proc->date        = $date;
            $usage_proc->save();
        }
    }

    public function saveCpuUsagePgpgins($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_pgpgin = new UsagePgpgin();
            $usage_pgpgin->hostname_id = $hostname->id;
            $usage_pgpgin->project_id  = $hostname->project_id;
            $usage_pgpgin->hostname    = $hostname->hostname;
            $usage_pgpgin->pgpgin_s    = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_pgpgin->pgpgout_s   = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_pgpgin->fault_s     = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_pgpgin->majflt_s    = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_pgpgin->pgfree_s    = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_pgpgin->pgscank_s   = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_pgpgin->pgscand_s   = (isset($section[7]) && $section[7] != '') ? $section[7] : '0.00';
            $usage_pgpgin->pgsteal_s   = (isset($section[8]) && $section[8] != '') ? $section[8] : '0.00';
            $usage_pgpgin->vmeff       = (isset($section[9]) && $section[9] != '') ? $section[9] : '0.00';
            $usage_pgpgin->date        = $date;
            $usage_pgpgin->save();
        }
    }

    public function saveCpuUsageTps($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_tps = new UsageTps();
            $usage_tps->hostname_id = $hostname->id;
            $usage_tps->project_id  = $hostname->project_id;
            $usage_tps->hostname    = $hostname->hostname;
            $usage_tps->tps         = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_tps->rtps        = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_tps->wtps        = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_tps->bread_s     = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_tps->bwrtn_s     = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_tps->date        = $date;
            $usage_tps->save();
        }
    }

    public function saveCpuUsageFrmpg($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_frmpg = new UsageFrmpg();
            $usage_frmpg->hostname_id = $hostname->id;
            $usage_frmpg->project_id  = $hostname->project_id;
            $usage_frmpg->hostname    = $hostname->hostname;
            $usage_frmpg->frmpg_s     = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_frmpg->bufpg_s     = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_frmpg->campg_s     = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_frmpg->date        = $date;
            $usage_frmpg->save();
        }
    }

    public function saveCpuUsageKbmemfree($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_kbmemfree = new UsageKbmemfree();
            $usage_kbmemfree->hostname_id = $hostname->id;
            $usage_kbmemfree->project_id  = $hostname->project_id;
            $usage_kbmemfree->hostname    = $hostname->hostname;
            $usage_kbmemfree->kbmemfree   = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_kbmemfree->kbmemused   = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_kbmemfree->memused     = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_kbmemfree->kbbuffers   = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_kbmemfree->kbcached    = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_kbmemfree->kbcommit    = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_kbmemfree->commit      = (isset($section[7]) && $section[7] != '') ? $section[7] : '0.00';
            $usage_kbmemfree->kbactive    = (isset($section[8]) && $section[8] != '') ? $section[8] : '0.00';
            $usage_kbmemfree->kbinact     = (isset($section[9]) && $section[9] != '') ? $section[9] : '0.00';
            $usage_kbmemfree->kbdirty     = (isset($section[10]) && $section[10] != '') ? $section[10] : '0.00';
            $usage_kbmemfree->date        = $date;
            $usage_kbmemfree->save();
        }
    }

    public function saveCpuUsageKbswpfree($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_kbswpfree = new UsageKbswpfree();
            $usage_kbswpfree->hostname_id = $hostname->id;
            $usage_kbswpfree->project_id  = $hostname->project_id;
            $usage_kbswpfree->hostname    = $hostname->hostname;
            $usage_kbswpfree->kbswpfree   = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_kbswpfree->kbswpused   = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_kbswpfree->swpused     = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_kbswpfree->kbswpcad    = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_kbswpfree->swpcad      = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_kbswpfree->date        = $date;
            $usage_kbswpfree->save();
        }
    }

    public function saveCpuUsageKbhugfree($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_kbhugfree = new UsageKbhugfree();
            $usage_kbhugfree->hostname_id = $hostname->id;
            $usage_kbhugfree->project_id  = $hostname->project_id;
            $usage_kbhugfree->hostname    = $hostname->hostname;
            $usage_kbhugfree->kbhugfree   = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_kbhugfree->kbhugused   = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_kbhugfree->hugused     = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_kbhugfree->date        = $date;
            $usage_kbhugfree->save();
        }
    }

    public function saveCpuUsageDentunusd($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_dentunusd = new UsageDentunusd();
            $usage_dentunusd->hostname_id = $hostname->id;
            $usage_dentunusd->project_id  = $hostname->project_id;
            $usage_dentunusd->hostname    = $hostname->hostname;
            $usage_dentunusd->dentunusd   = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_dentunusd->file_nr     = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_dentunusd->inode_nr    = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_dentunusd->pty_nr      = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_dentunusd->date        = $date;
            $usage_dentunusd->save();
        }
    }

    public function saveCpuUsageRunqsz($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_runqsz = new UsageRunqsz();
            $usage_runqsz->hostname_id = $hostname->id;
            $usage_runqsz->project_id  = $hostname->project_id;
            $usage_runqsz->hostname    = $hostname->hostname;
            $usage_runqsz->runq_sz     = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_runqsz->plist_sz    = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_runqsz->davg_1      = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_runqsz->davg_5      = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_runqsz->davg_15     = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_runqsz->blocked     = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_runqsz->date        = $date;
            $usage_runqsz->save();
        }
    }

    public function saveCpuUsageTty($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_tty = new UsageTty();
            $usage_tty->hostname_id = $hostname->id;
            $usage_tty->project_id  = $hostname->project_id;
            $usage_tty->hostname    = $hostname->hostname;
            $usage_tty->tty         = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_tty->rcvin_s     = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_tty->xmtin_s     = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_tty->framerr_s   = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_tty->prtyerr_s   = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_tty->brk_s       = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_tty->ovrun_s     = (isset($section[7]) && $section[7] != '') ? $section[7] : '0.00';
            $usage_tty->date        = $date;
            $usage_tty->save();
        }
    }

    public function saveCpuUsageDev($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_dev = new UsageDev();
            $usage_dev->hostname_id = $hostname->id;
            $usage_dev->project_id  = $hostname->project_id;
            $usage_dev->hostname    = $hostname->hostname;
            $usage_dev->dev         = (isset($section[1]) && $section[1] != '') ? $section[1] : '';
            $usage_dev->tps         = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_dev->rd_sec_s    = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_dev->wr_sec_s    = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_dev->avgrq_sz    = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_dev->avgqu_sz    = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_dev->await       = (isset($section[7]) && $section[7] != '') ? $section[7] : '0.00';
            $usage_dev->svctm       = (isset($section[8]) && $section[8] != '') ? $section[8] : '0.00';
            $usage_dev->util        = (isset($section[9]) && $section[9] != '') ? $section[9] : '0.00';
            $usage_dev->date        = $date;
            $usage_dev->save();
        }
    }

    public function saveCpuUsageIfacerxpck($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_dev = new UsageDev();
            $usage_dev->hostname_id = $hostname->id;
            $usage_dev->project_id  = $hostname->project_id;
            $usage_dev->hostname    = $hostname->hostname;
            $usage_dev->iface       = (isset($section[1]) && $section[1] != '') ? $section[1] : '';
            $usage_dev->rxpck_s     = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_dev->txpck_s     = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_dev->rxkb_s      = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_dev->txkb_s      = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_dev->rxcmp_s     = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_dev->txcmp_s     = (isset($section[7]) && $section[7] != '') ? $section[7] : '0.00';
            $usage_dev->rxmcst_s    = (isset($section[8]) && $section[8] != '') ? $section[8] : '0.00';
            $usage_dev->date        = $date;
            $usage_dev->save();
        }
    }

    public function saveCpuUsageIfacerxerr($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_ifacerxerr = new UsageIfacerxerr();
            $usage_ifacerxerr->hostname_id = $hostname->id;
            $usage_ifacerxerr->project_id  = $hostname->project_id;
            $usage_ifacerxerr->hostname    = $hostname->hostname;
            $usage_ifacerxerr->iface       = (isset($section[1]) && $section[1] != '') ? $section[1] : '-';
            $usage_ifacerxerr->rxerr_s     = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_ifacerxerr->txerr_s     = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_ifacerxerr->coll_s      = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_ifacerxerr->rxdrop_s    = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_ifacerxerr->txdrop_s    = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_ifacerxerr->txcarr_s    = (isset($section[7]) && $section[7] != '') ? $section[7] : '0.00';
            $usage_ifacerxerr->rxfram_s    = (isset($section[8]) && $section[8] != '') ? $section[8] : '0.00';
            $usage_ifacerxerr->rxfifo_s    = (isset($section[9]) && $section[9] != '') ? $section[9] : '0.00';
            $usage_ifacerxerr->txfifo_s    = (isset($section[10]) && $section[10] != '') ? $section[10] : '0.00';
            $usage_ifacerxerr->date        = $date;
            $usage_ifacerxerr->save();
        }
    }

    public function saveCpuUsageCalls($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_calls = new UsageCalls();
            $usage_calls->hostname_id = $hostname->id;
            $usage_calls->project_id  = $hostname->project_id;
            $usage_calls->hostname    = $hostname->hostname;
            $usage_calls->call_s      = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_calls->retrans_s   = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_calls->read_s      = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_calls->write_s     = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_calls->access_s    = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_calls->getatt_s    = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_calls->date        = $date;
            $usage_calls->save();
        }
    }

    public function saveCpuUsageScalls($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_scalls = new UsageScalls();
            $usage_scalls->hostname_id = $hostname->id;
            $usage_scalls->project_id  = $hostname->project_id;
            $usage_scalls->hostname    = $hostname->hostname;
            $usage_scalls->scall_s     = (isset($section[1]) && $section[1] != '') ? $section[1] : '0.00';
            $usage_scalls->badcall_s   = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_scalls->packet_s    = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_scalls->udp_s       = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_scalls->tcp_s       = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_scalls->hit_s       = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_scalls->miss_s      = (isset($section[7]) && $section[7] != '') ? $section[7] : '0.00';
            $usage_scalls->sread_s     = (isset($section[8]) && $section[8] != '') ? $section[8] : '0.00';
            $usage_scalls->swrite_s    = (isset($section[9]) && $section[9] != '') ? $section[9] : '0.00';
            $usage_scalls->saccess_s   = (isset($section[10]) && $section[10] != '') ? $section[10] : '0.00';
            $usage_scalls->sgetatt_s   = (isset($section[11]) && $section[11] != '') ? $section[11] : '0.00';
            $usage_scalls->date        = $date;
            $usage_scalls->save();
        }
    }

    public function saveCpuUsageTotsck($sections, $date, $hostname) {
        foreach($sections as $section) {
            $usage_totsck = new UsageTotsck();
            $usage_totsck->hostname_id = $hostname->id;
            $usage_totsck->project_id  = $hostname->project_id;
            $usage_totsck->hostname    = $hostname->hostname;
            $usage_totsck->tty         = (isset($section[1]) && $section[1] != '') ? $section[1] : '-';
            $usage_totsck->tcpsck      = (isset($section[2]) && $section[2] != '') ? $section[2] : '0.00';
            $usage_totsck->udpsck      = (isset($section[3]) && $section[3] != '') ? $section[3] : '0.00';
            $usage_totsck->rawsck      = (isset($section[4]) && $section[4] != '') ? $section[4] : '0.00';
            $usage_totsck->ip_frag     = (isset($section[5]) && $section[5] != '') ? $section[5] : '0.00';
            $usage_totsck->tcp_tw      = (isset($section[6]) && $section[6] != '') ? $section[6] : '0.00';
            $usage_totsck->date        = $date;
            $usage_totsck->save();
        }
    }

    public function getCpuUsage($path) {
        $input   = fopen($path, "r");
        $outputs = [];
        $final_output = [];
        $line_status  = false;
        $index = 0;
        $line_number = 0;
        
        while(!feof($input)) {
            $flag = false;
            $line = fgets($input);
            if($line_number == 0) {
                $data['file'] = trim($line);
            }
            if($line_number == 1) {
                $data['hostname'] = trim($line);
            }
            
            if(str_contains($line, 'Linux')) { 
                $split = explode(" ", trim($line));
                $index = 0;
            } else {
                if(strlen($line) == 1) {
                    $line_status = true;
                } else {
                    if(!str_contains($line, 'Average:')) {
                        if($line_status == true) {
                            $flag = true;
                            $index++;
                        }
                    } else {
                        $flag = true;
                        $index++;
                    }
                    $line_status = false;
                }
            }
            if($flag == true) {
                $outputs[trim($split[3])][$index] = $line;
            }
            $line_number++;
        }
        
        $final_array = [];
        $new_index  = 0;
        $lists = array('ignore', 'cpu', 'proc/s', 'pswpin/s', 'pgpgin/s', 'tps', 'frmpg/s', 'kbmemfree', 'kbswpfree', 'kbhugfree', 'dentunusd', 'runq-sz', 'TTY', 'DEV', 'IFACE', 'IFACE', 'call/s', 'scall/s', 'totsck');
        foreach($outputs as $key => $output) {
            $date = $key;
            $new_index  = 0;
            foreach($output as $key => $value) {
                if(str_contains($value, 'Average:')) {
                    if(isset($previous_line) && $previous_line != '') {
                        $new_index++;
                        $final_array[$date][$lists[$new_index]][$key-1] = $previous_line;
                    }
                    $final_array[$date][$lists[$new_index]][$key] = $value;
                    $previous_line = '';
                } else {
                    $previous_line = $value;
                }
            }
        }

        $data['final_array'] = $final_array;

        return $data;
    }
}
