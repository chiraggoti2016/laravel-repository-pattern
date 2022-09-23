<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CpuCountDatabaseDetail;
use App\Models\OptionsPacksDatabaseDetail;
use App\Models\OptionsPacksParameterDetail;
use App\Models\OptionsPacksMultitenant;
use App\Models\OptionsPacksProductDetail;
use App\Models\OptionsPacksProduct;
use App\Models\Project;
use App\Models\CpuCount;
use App\Models\Hostname;
use Storage;
use DB;

class OptionsPacksController extends Controller
{
    //
    public function index(Request $request, $slug) {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:txt' 
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        try {
            DB::beginTransaction();

            $project  = Project::where('slug', $slug)->first();

            $filename  = $request->file->getClientOriginalName();
            $extension = $request->file->getClientOriginalExtension();

            $file = Storage::disk('public')->put('options-packs/'.$project->folder, $request->file);

            $path = Storage::disk('public')->path($file);

            $newfile  = explode('/', $file)[2];

            $sections = $this->getOptionsPacks($path);
            $cpu_host_name = trim($sections['HOST_NAME_AND_PARAMETER']['HOST_NAME'][0]['HOST_NAME']);
            $instance_name = trim($sections['HOST_NAME_AND_PARAMETER']['HOST_NAME'][0]['INSTANCE_NAME']);
            
            if(isset($cpu_host_name) && $cpu_host_name != '' && isset($instance_name) && $instance_name != '') {
                $cpu = $this->options_packs($sections, $project, $filename, $newfile, $file, $instance_name);

                if($cpu == true) {
                    dump('All good.');
                    DB::commit();
                } else {
                    dump('Oops, Error!');
                }
            } else {
                dd('Invalid data.');
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function options_packs($sections, $project, $filename, $newfile, $file, $instance_name) {
        try {
            $database  = $sections['HOST_NAME_AND_PARAMETER']['HOST_NAME'][0];
            $parameter = (isset($sections['HOST_NAME_AND_PARAMETER']['PARAMETER']) && $sections['HOST_NAME_AND_PARAMETER']['PARAMETER'] != '') ? $sections['HOST_NAME_AND_PARAMETER']['PARAMETER'] : [];
            $multitenant = $sections['CON_ID_TABLE'];
            $product = $sections['PRODUCT_TABLE'];
            $product_details = $sections['PRODUCT_DETAIL_TABLE'];

            if(isset($database['HOST_NAME']) && $database['HOST_NAME'] != '') {
                $hostname = Hostname::where('project_id', $project->id)->where('hostname', $database['HOST_NAME'])->first();
                if(isset($hostname) && $hostname != '') {
                    // existing entry will be updated
                } else {
                    $hostname = new Hostname();
                }
                $hostname->project_id = $project->id;
                $hostname->hostname   = $database['HOST_NAME'];
                $hostname->options_packs_file      = $filename;
                $hostname->options_packs_new_file  = $newfile;
                $hostname->options_packs_file_path = $file;
                $hostname->options_packs_date      = date('Y-m-d');
                $hostname->save();
                $cpu_count_database_detail = CpuCountDatabaseDetail::where('db_name', $instance_name)->where('hostname_id', $hostname->id)->where('project_id', $project->id)->first();

                if(isset($cpu_count_database_detail) && $cpu_count_database_detail != '') {
                    // DB found.
                } else {
                    dd('Database ' . $instance_name . ' for the host ' . $hostname->hostname . " not found.");
                }
            } else {
                return false;
            }

            if(!empty($database) && count($database) > 0 ) {
                OptionsPacksDatabaseDetail::where('hostname_id', $hostname->id)->where('project_id', $project->id)->where('cpu_count_database_detail_id', $cpu_count_database_detail->id)->delete();
                
                $database_ins = new OptionsPacksDatabaseDetail();
                $database_ins->hostname_id   = $hostname->id;
                $database_ins->project_id    = $project->id;
                $database_ins->cpu_count_database_detail_id = $cpu_count_database_detail->id;
                $database_ins->hostname      = $hostname->hostname;
                $database_ins->instance_name = $database['INSTANCE_NAME'];
                $database_ins->db_name       = $database['DATABASE_NAME'];
                $database_ins->open_mode     = $database['OPEN_MODE'];
                $database_ins->db_role       = $database['DATABASE_ROLE'];
                $database_ins->created       = $database['CREATED'];
                $database_ins->dbid          = $database['DBID'];
                $database_ins->version       = $database['VERSION'];
                $database_ins->banner        = preg_replace('/(?<!\ )[A-Z]/', ' $0', $database['BANNER']);
                $database_ins->save();

                if(isset($cpu_count_database_detail) && $cpu_count_database_detail != '') {
                    $cpu_count_database_detail->instance_name = $database['INSTANCE_NAME'];
                    $cpu_count_database_detail->database_name = $database['DATABASE_NAME'];
                    $cpu_count_database_detail->open_mode     = $database['OPEN_MODE'];
                    $cpu_count_database_detail->db_role       = $database['DATABASE_ROLE'];
                    $cpu_count_database_detail->dbid          = $database['DBID'];
                    $cpu_count_database_detail->version       = $database['VERSION'];
                    $cpu_count_database_detail->banner        = preg_replace('/(?<!\ )[A-Z]/', ' $0', $database['BANNER']);
                    $cpu_count_database_detail->save();
                }
            }

            if(!empty($parameter) && count($parameter) > 0 ) {
                OptionsPacksParameterDetail::where('hostname_id', $hostname->id)->where('project_id', $project->id)->where('cpu_count_database_detail_id', $cpu_count_database_detail->id)->delete();
                if(!empty($parameter) && count($parameter) > 0) {
                    foreach($parameter as $para) {
                        $parameter_ins = new OptionsPacksParameterDetail();
                        $parameter_ins->hostname_id = $hostname->id;
                        $parameter_ins->project_id  = $project->id;
                        $parameter_ins->cpu_count_database_detail_id = $cpu_count_database_detail->id;
                        $parameter_ins->hostname    = $hostname->hostname;
                        $parameter_ins->parameter   = $para['PARAMETER'];
                        $parameter_ins->value       = $para['VALUE'];
                        $parameter_ins->save();
                    }
                }
            }

            if(!empty($multitenant) && count($multitenant) > 0 ) {
                OptionsPacksMultitenant::where('hostname_id', $hostname->id)->where('project_id', $project->id)->where('cpu_count_database_detail_id', $cpu_count_database_detail->id)->delete();
                if(!empty($multitenant['CON_ID']) && count($multitenant['CON_ID']) > 0) {
                    foreach($multitenant['CON_ID'] as $mul) {
                        $multitenant_ins = new OptionsPacksMultitenant();
                        $multitenant_ins->hostname_id = $hostname->id;
                        $multitenant_ins->project_id  = $project->id;
                        $multitenant_ins->cpu_count_database_detail_id = $cpu_count_database_detail->id;
                        $multitenant_ins->hostname    = $hostname->hostname;
                        $multitenant_ins->con_id      = $mul['CON_ID'];
                        $multitenant_ins->name        = $mul['NAME'];
                        $multitenant_ins->open_mode   = $mul['OPEN_MODE'];
                        $multitenant_ins->restricted  = $mul['RESTRICTED'];
                        $multitenant_ins->remarks     = $mul['REMARKS'];
                        $multitenant_ins->save();
                    }
                }
            }

            

            if(!empty($product) && count($product) > 0 ) {
                OptionsPacksProduct::where('hostname_id', $hostname->id)->where('project_id', $project->id)->where('cpu_count_database_detail_id', $cpu_count_database_detail->id)->delete();
                if(!empty($product['PRODUCT']) && count($product['PRODUCT']) > 0) {
                    foreach($product['PRODUCT'] as $product) {
                        if($product['PRODUCT'] != 'PRODUCT' && $product['USAGE'] != 'USAGE' && $product['LAST_SAMPLE_DATE'] != 'LAST_SAMPLE_DATE' && $product['FIRST_USAGE_DATE'] != 'FIRST_USAGE_DATE') {
                            $product_ins = new OptionsPacksProduct();
                            $product_ins->hostname_id      = $hostname->id;
                            $product_ins->project_id       = $project->id;
                            $product_ins->cpu_count_database_detail_id = $cpu_count_database_detail->id;
                            $product_ins->hostname         = $hostname->hostname;
                            $product_ins->con_name         = (isset($product['CON_NAME']) && $product['CON_NAME'] != '') ? $product['CON_NAME'] : '--ALL--';
                            $product_ins->product          = trim(preg_replace('/(?<!\ )[A-Z]/', ' $0', $product['PRODUCT']));
                            $product_ins->usage            = $product['USAGE'];
                            if(isset($product['LAST_SAMPLE_DATE']) && $product['LAST_SAMPLE_DATE'] != '') {
                                $product_ins->last_sample_date = $this->returnDate($product['LAST_SAMPLE_DATE']);
                            }
                            if(isset($product['FIRST_USAGE_DATE']) && $product['FIRST_USAGE_DATE'] != '') {
                                $product_ins->first_usage_date = $this->returnDate($product['FIRST_USAGE_DATE']);
                            }
                            if(isset($product['LAST_USAGE_DATE']) && $product['LAST_USAGE_DATE'] != '') {
                                $product_ins->last_usage_date  = $this->returnDate($product['LAST_USAGE_DATE']);
                            }
                            $product_ins->save();
                        }
                    }
                }
            }
            
            if(!empty($product_details) && count($product_details) > 0 ) {
                OptionsPacksProductDetail::where('hostname_id', $hostname->id)->where('project_id', $project->id)->where('cpu_count_database_detail_id', $cpu_count_database_detail->id)->delete();
                if(!empty($product_details['PRODUCT']) && count($product_details['PRODUCT']) > 0) {
                    foreach($product_details['PRODUCT'] as $product) {
                        if($product['PRODUCT'] != 'PRODUCT' && $product['USAGE'] != 'USAGE' && $product['LAST_SAMPLE_DATE'] != 'LAST_SAMPLE_DATE' && $product['FIRST_USAGE_DATE'] != 'FIRST_USAGE_DATE') {
                            $product_ins = new OptionsPacksProductDetail();
                            $product_ins->hostname_id        = $hostname->id;
                            $product_ins->project_id         = $project->id;
                            $product_ins->cpu_count_database_detail_id = $cpu_count_database_detail->id;
                            $product_ins->hostname           = $hostname->hostname;
                            $product_ins->con_name           = (isset($product['CON_NAME']) && $product['CON_NAME'] != '') ? $product['CON_NAME'] : '--ALL--';
                            $product_ins->product            = trim(preg_replace('/(?<!\ )[A-Z]/', ' $0', $product['PRODUCT']));
                            $product_ins->feature_being_used = preg_replace('/(?<!\ )[A-Z]/', ' $0', $product['FEATURE_BEING_USED']);
                            $product_ins->usage              = $product['USAGE'];
                            $product_ins->dbid               = $product['DBID'];
                            $product_ins->version            = $product['VERSION'];
                            $product_ins->detected_usages    = $product['DETECTED_USAGES'];
                            $product_ins->total_samples      = $product['TOTAL_SAMPLES'];
                            $product_ins->currently_used     = $product['CURRENTLY_USED'];
                            if(isset($product['LAST_SAMPLE_DATE']) && $product['LAST_SAMPLE_DATE'] != '') {
                                $product_ins->last_sample_date = $this->returnDate($product['LAST_SAMPLE_DATE']);
                            }
                            if(isset($product['FIRST_USAGE_DATE']) && $product['FIRST_USAGE_DATE'] != '') {
                                $product_ins->first_usage_date = $this->returnDate($product['FIRST_USAGE_DATE']);
                            }
                            if(isset($product['LAST_USAGE_DATE']) && $product['LAST_USAGE_DATE'] != '') {
                                $product_ins->last_usage_date = $this->returnDate($product['LAST_USAGE_DATE']);
                            }
                            $product_ins->extra_feature_info = $product['EXTRA_FEATURE_INFO'];
                            $product_ins->save();
                        }
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function getOptionsPacks($path) {
        define("_TABLE", "TABLE");
        define("_EMPTY", "");
        define("_VSP", "_VSP");
        define("_HSP", "_HSP");
        define("_IGN", "_IGN");
        define("_MID_IGNORE", "_MID_IGNORE");
        
        define("_SP_COLON", ":");
        define("_SP_SPACE", " ");
        define("_SP_PIPE", "|");
        define("_SP_DASH", "--");

        define("_TYPE", "_TYPE");
        define("_TYPE_V", "V");
        define("_TYPE_H", "H");
        define("_TYPE_VH", "VH");

        $sectionType = [
            // section 1
            [ _TYPE => _TYPE_V, _TABLE => ["HOST_NAME", "PARAMETER"], _VSP => _SP_PIPE, _IGN => _SP_DASH  ],
            // section 2
            [ _TYPE => _TYPE_V, _TABLE => ["CON_ID"], _VSP => _SP_PIPE, _IGN => _SP_DASH, _MID_IGNORE => TRUE ],
            // section 3
            [ _TYPE => _TYPE_V, _TABLE => ["LAST_DBA_FUS_DBID"], _VSP => _SP_PIPE, _IGN => _SP_DASH ],
            // section 4
            [ _TYPE => _TYPE_V, _TABLE => ["PRODUCT"], _VSP => _SP_PIPE, _IGN => _SP_DASH, _MID_IGNORE => TRUE  ],
            // section 5
            [ _TYPE => _TYPE_V, _TABLE => ["PRODUCT"], _VSP => _SP_PIPE, _IGN => _SP_DASH, _MID_IGNORE => TRUE  ],
            // section 6
            [ _TYPE => _EMPTY  ],        
            // section 7
            [ _TYPE => _EMPTY  ],
            // section 8
            [ _TYPE => _EMPTY  ],
        ];
    
        $sectionNames = [
            "HOST_NAME_AND_PARAMETER", //1
            "CON_ID_TABLE",//2
            "LAST_DBA_FUS_DBID_TABLE",//3
            "PRODUCT_TABLE",//4
            "PRODUCT_DETAIL_TABLE",//5
            "DESCRIPTION", // 6
            "NOTES", // 7
            "DISCLAIMER", //8
        ];
        
        // sectionSplitor 
        $sectionSp = '\+';
        $sections = [];
        $sectionIndex = 0;
        $tableIndex = 0;
        $tpIndex = 0;
        $subTableKey = '';
        $tableColumns = [];
        $sectionSpCount = 1;

        if ($file = fopen($path, "r")) {
            while(!feof($file)) {
                $line = fgets($file);

                if( preg_match("/($sectionSp{50,})/i", $line) ) {
                    // echo "{$sectionIndex}{$sectionSpCount} $line \n";
                    $type = $sectionType[$sectionIndex];
                    if (isset($type[_MID_IGNORE]) && $type[_MID_IGNORE] && $sectionSpCount === 0) {
                        $sectionSpCount = 1;
                        continue;
                    }
                    
                    if ($sectionSpCount === 1) {
                        $sectionIndex++;
                        $tableIndex=0;
                        $sectionSpCount = 0;
                        $tableColumns = [];    
                        $tpIndex = 0;
                        $subTableKey = '';
                        $columns = [];
                    } else
                        $sectionSpCount++;
                    continue;
                }
                // echo '<pre>';print_r(['sec' => $sectionIndex, 'tableColumns'=>$tableColumns]);echo '</pre>';
                if( $sectionIndex >= 8) {
                    break;
                }
                if( empty($line) || preg_replace("/\s+/","", $line) === "" ) {
                    continue;
                }
                // do your action:start
                $type = $sectionType[$sectionIndex];
                $sectionName = isset($sectionNames[$sectionIndex]) ? $sectionNames[$sectionIndex] : ('SEC-' . $sectionIndex);
                if($type[_TYPE] === _EMPTY) {
                    if( $tableIndex == 0)
                        $sections[$sectionName] = $line;
                    else $sections[$sectionName] .= $line;
                } else {
                    $line = preg_replace("/\s+/"," ", $line);
                    $line = trim($line);
                    // Vertical spliting
                    if($type[_TYPE] === _TYPE_V) {
                        $vsp = $type[_VSP];
                        $match_pattern = _SP_PIPE === $vsp ? "/\\$vsp/" : "/$vsp/";
        
                        if(preg_match($match_pattern, $line) === 0){
                            if($tableIndex === 0) {
                                $storeAt = 'caption';
                            } else {
                                $storeAt = 'data';
                            }
                            if(preg_match("/ERROR at line /", $line) === 0) {
                                if($storeAt==='caption') {
                                    $sections[$sectionName][$storeAt] = $line;
                                } else {
                                    $sections[$sectionName][$storeAt][] = $line;
                                }
                            } else {
                                $sections[$sectionName]['error'] = true;
                            }
                            $tableIndex++;
                            continue;
                        } else {
                            $line = preg_replace("/\s+/","", $line);
                            $columns = explode($type[_VSP], $line);
                            
                            // echo '<pre>';print_r([$columns, $type[_TABLE][$tpIndex]]);die;
                            $tp = isset($type[_TABLE][$tpIndex]) ? $type[_TABLE][$tpIndex] : '';
                            // echo '<pre>';var_dump( [$tp, $subTableKey, $columns]);die;
                            
                            if( !empty($tp) && (
                                    count($tableColumns) === 0 ||
                                    (!empty($subTableKey) && in_array($tp, $columns)) 
                                )
                            ) {
                                $subTableKey = $tp;
                                $tpIndex++;
                                $tableColumns = $columns;
                                continue;
                            }
        
                            if (count($tableColumns) > 0) {
                                $values = $columns;
                                if(count($values) > 0) {
                                    if (isset($type[_IGN])) {
                                        $ign = $type[_IGN];
                                        if (preg_match("/$ign+/", $values[0]) > 0) {
                                            $tableIndex++;
                                            continue;
                                        }
                                    }
                                    $row = [];
                                    foreach($tableColumns as $index => $column) {
                                        $row[$column] = isset($values[$index]) ? $values[$index] : "";
                                    }
                                    $sections[$sectionName][$subTableKey][] = $row;
                                }
                            }                    
                        }
                    }
                }
                // do your action:end
                $tableIndex++;
            }
        }

        return $sections;
    }

    public function returnDate($date) {
        $explode = explode("_", $date);
        $new_date = str_replace('.', '-', $explode[0]);
        //$new_time = str_replace('.', '-', $explode[1]);
        
        return date('Y-m-d H:i:s', strtotime($new_date));
    }
}
