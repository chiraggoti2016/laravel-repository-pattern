<?php
namespace App\Repositories;

use App\Models\Project;
use App\Models\User;
use App\Contracts\ProjectContract;
use App\Http\Resources\Project as ProjectResource;
use Illuminate\Http\Request;
use DataTableCollectionResource;
use DB;

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

        $data = Project::paginate($length);
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
            dd($e->getMessage());
            DB::rollBack();
            //Log::debug('Project Repository : ',[ 'error' =>$e ]);
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
        }
        return false;
    }

    private function createUpdateParticipants($project, $participants) {
        $participantUserIds = [];
        foreach($participants as $each) {    
            $password = '123456';
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

}

?>
