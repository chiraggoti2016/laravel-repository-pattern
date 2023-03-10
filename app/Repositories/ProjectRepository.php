<?php
namespace App\Repositories;

use App\Models\Project;
use App\Models\ProjectStage;
use App\Models\Hostname;
use App\Models\User;
use App\Models\CpuCountDatabaseDetail;
use App\Models\OptionsPacksProduct;
use App\Contracts\ProjectContract;
use App\Http\Resources\Project as ProjectResource;
use Illuminate\Http\Request;
use DataTableCollectionResource;
use DB;
use Log;

class ProjectRepository extends BaseRepository implements ProjectContract
{
    function __construct() {
        parent::__construct(new Project);
    }
    
    function list(Request $request) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        $data = [];

        $authUser = auth()->user();
        if($authUser) {
            if($authUser->role === 'admin') {
                $data = Project::paginate($length);
            } else if($authUser->role === 'partner') {
                $data = $this->model->whereHas('customers', function($q) use($authUser) {
                    return $q->where('added_by', $authUser->id);
                })->paginate($length);
            }
        }

        return new DataTableCollectionResource($data);
    }

    function create($data) {
        DB::beginTransaction();
        try {
            if($project = parent::create($data)) {
                DB::commit();
                return $project;
            }
        } catch(\Throwable $e){
            DB::rollBack();
            Log::debug('Project Repository : ',[ 'error' =>$e ]);
            
            abort(422, $e->getMessage());
        }
        return false;
    }

    function update($data, $id) {
        DB::beginTransaction();
        try {
            $participants = [];
            if(isset($data['participants'])) {
                $participants = $data['participants'];
                unset($data['participants']);
            }
    
            if(parent::update($data, $id)) {
                $project = $this->findData($id);
                $this->createUpdateParticipants($project, $participants);
                DB::commit();
                return $project;
            }
        }catch(\Throwable $e){
            DB::rollBack();
            \Log::debug('Project Repository : ',[ 'error' =>$e ]);
            
            abort(422, $e->getMessage());
        }
        return false;
    }

    private function createUpdateParticipants($project, $participants) {
        $participantUserIds = [];
        foreach($participants as $each) {    
            $password = '';
            $name = explode(' ', $each['name']);
            unset($each['name']);
            $userData = array_merge([
                'first_name' => isset($name[0]) ? $name[0] : '',
                'last_name' => isset($name[1]) ? $name[1] : '',
                'password' => \Hash::make($password),
                'role'      => 'customer',
            ], $each);
            $user = User::updateOrCreate(['id' =>$userData['id']],$userData);
            $participantUserIds[$user->id] = [ 
                'pvcot' => $each['pivot']['pvcot'],
                'raci'  => $each['pivot']['raci'],
            ];
        }
        
        $project->participants()->sync($participantUserIds);
        return $participantUserIds;
    }

    function hosts(Request $request, $slug) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        
        DB::statement('SET @cnt=0');
        $data = Project::select('projects.*', 'hostnames.*', DB::raw('(@cnt := @cnt + 1) AS `index`'))
                    ->leftjoin('hostnames', 'hostnames.project_id', '=', 'projects.id')
                    ->where('slug', $slug)
                    ->paginate($length);

        return new DataTableCollectionResource($data);
    }

    function hostdetails(Request $request, $slug) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $project = Project::where('slug', $slug)->first();

        $data = Hostname::select('hostnames.*', 'hostnames.id as hostname_id', DB::raw("(SELECT SUM(`davg_15`) FROM `usage_runqszs` where `usage_runqszs`.`hostname_id` = `hostname_id`) as ldavg_sum"))
                        ->with('project', 'database', 'details', 'memory', 'usage_database', 'disk')
                        ->where('project_id', $project->id)
                        ->paginate($length);

        return new DataTableCollectionResource($data);
    }

    function databasedetails(Request $request, $slug, $host_id) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $project = Project::where('slug', $slug)->first();
        $hostname = Hostname::find($host_id);
        
        $data = CpuCountDatabaseDetail::select('cpu_count_database_details.*', 'cpu_count_database_details.id as database_detail_id', 'cpu_count_database_details.project_id as database_detail_project_id', 'cpu_count_database_details.hostname_id as database_detail_hostname_id', 'cpu_count_database_details.cpu_count_id as database_detail_cpu_count_id',
                        DB::raw("(SELECT count(*) FROM `options_packs_products` WHERE `product` = 'Partitioning' AND `hostname_id` = database_detail_hostname_id AND `project_id` = database_detail_project_id AND `cpu_count_database_detail_id` = database_detail_cpu_count_id) as partioning"),
                        DB::raw("(SELECT count(*) FROM `options_packs_products` WHERE `product` = 'Diagnostics Pack' AND `hostname_id` = database_detail_hostname_id AND `project_id` = database_detail_project_id AND `cpu_count_database_detail_id` = database_detail_cpu_count_id) as diagnostics"),
                        DB::raw("(SELECT count(*) FROM `options_packs_products` WHERE `product` = 'Tuning Pack' AND `hostname_id` = database_detail_hostname_id AND `project_id` = database_detail_project_id AND `cpu_count_database_detail_id` = database_detail_cpu_count_id) as tuning"),
                        DB::raw("(SELECT count(*) FROM `options_packs_products` WHERE `product` = 'R A Cor R A C One Node' AND `hostname_id` = database_detail_hostname_id AND `project_id` = database_detail_project_id AND `cpu_count_database_detail_id` = database_detail_cpu_count_id) as rac"),
                        DB::raw("(SELECT count(*) FROM `options_packs_multitenants` WHERE `hostname_id` = database_detail_hostname_id AND `project_id` = database_detail_project_id AND `cpu_count_database_detail_id` = database_detail_cpu_count_id) as cbdpbd"))
                        ->with('options_packs_database_detail', 'options_packs_multitenant')
                        ->where('db_type', 'ora')
                        ->where('hostname_id', $hostname->id)
                        ->get();

        return new DataTableCollectionResource($data);
    }

    function specificdatabasedetails(Request $request, $database_id) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $data  = OptionsPacksProduct::where('cpu_count_database_detail_id', $database_id)
                    ->orderByRaw("FIELD(`usage`, 'CURRENT_USAGE', 'PAST_USAGE', 'NO_USAGE')")
                    ->paginate($length);

        return new DataTableCollectionResource($data);
    }

    function specificdatabasefeaturedetails(Request $request, $database_id) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $data = OptionsPacksProductDetail::where('cpu_count_database_detail_id', $id)
                    ->orderByRaw("FIELD(`usage`, 'CURRENT_USAGE', 'PAST_USAGE', 'NO_CURRENT_USAGE', 'SUPPRESSED_DUE_TO_BUG')")
                    ->paginate($length);

        return new DataTableCollectionResource($data);
    }

    function stageUpdate($data) {
        DB::beginTransaction();
        try {
                        
            if($project_stage = ProjectStage::updateOrCreate([
                "project_id"        => $data['project_id'],
                "scope_stage_id"    => $data['scope_stage_id'],
            ],[
                "status"            => $data['status'],
                "enddate"           => $data['status'] === "complete" ? date('Y-m-d h:i:s'):null,    
            ])) {
                // set status
                if($project = Project::find($data['project_id'])){
                    $totalCount = null;
                    $skipCompleteCount = $project->stages()->whereIn('status',['complete','skip'])->count();
                    if(isset($project_stage->scope_stage->scopeModel->stages)){
                        $totalCount = $project_stage->scope_stage->scopeModel->stages->count();
                    }
                    
                    $project->update([
                        'status' => $totalCount === $skipCompleteCount ? 'completed': 'in progress'
                    ]);

                }
                DB::commit();
                return ['message' => 'change stage successfully.'];
            }
        } catch(\Throwable $e){
            DB::rollBack();
            Log::debug('Project Repository : ',[ 'error' =>$e ]);
            
            abort(422, $e->getMessage());
        }
        return false;
    }
    
}

?>
