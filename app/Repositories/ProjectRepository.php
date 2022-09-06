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

    function update($data, $id) {
        DB::beginTransaction();
        try {
            $users = $data['users'];
            unset($data['users']);
            if(parent::update($data, $id)) {
                $project = $this->findData($id);
                $this->createUpdateUsers($project, $users);
                DB::commit();
                return $project;
            }
        }catch(\Throwable $e){
            DB::rollBack();
            Log::debug('Customer Repository : ',[ 'error' =>$e ]);
        }
        return false;
    }

}

?>
