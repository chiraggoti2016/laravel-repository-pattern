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
            //Log::debug('Customer Repository : ',[ 'error' =>$e ]);
        }
        return false;
    }

    function update($data, $id) {
        DB::beginTransaction();
        try {
            if($project = parent::update($data, $id)) {
                DB::commit();
                return $project;
            }
        }catch(\Throwable $e){
            DB::rollBack();
            //Log::debug('Customer Repository : ',[ 'error' =>$e ]);
        }
        return false;
    }

}

?>
