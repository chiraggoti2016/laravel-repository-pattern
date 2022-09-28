<?php
namespace App\Repositories;

use App\Models\Customer;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectParticipant;
use App\Contracts\CustomerContract;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Http\Request;
use DataTableCollectionResource;
use DB;

class CustomerRepository extends BaseRepository implements CustomerContract
{
    function __construct() {
        parent::__construct(new Customer);
    }

    function list(Request $request) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        
        $query = Customer::eloquentQuery($orderBy, $orderByDir, $searchValue)->withCount(['users', 'projects'])->where('added_by', $request->user()->id);
        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

    function create($data) {
        DB::beginTransaction();
        try {
            $users = $data['users'];
            $projects = $data['projects'];
            if(isset($data['users'])) unset($data['users']);
            if(isset($data['projects'])) unset($data['projects']);
            if($customer = parent::create($data)) {
                $usersIds = $this->createUpdateUsers($customer, $users);
                $projectsIds = $this->createUpdateProjects($customer, $projects);
                $this->attachProjectParticipants($projectsIds, $usersIds);
                DB::commit();
                return $customer;
            }
        }catch(\Throwable $e){
            DB::rollBack();
            \Log::debug('Customer Repository : ',[ 'error' =>$e ]);
            
            abort(404, $e->getMessage());
        }
        return false;
    }

    function update($data, $id) {
        DB::beginTransaction();
        try {
            $users = $data['users'];
            $projects = $data['projects'];
            if(isset($data['users'])) unset($data['users']);
            if(isset($data['projects'])) unset($data['projects']);
            if(parent::update($data, $id)) {
                $customer = $this->findData($id);
                $usersIds = $this->createUpdateUsers($customer, $users);
                $projectsIds = $this->createUpdateProjects($customer, $projects);
                $this->attachProjectParticipants($projectsIds, $usersIds);
                DB::commit();
                return $customer;
            }
        }catch(\Throwable $e){
            DB::rollBack();
            \Log::debug('Customer Repository : ',[ 'error' =>$e ]);
            
            abort(404, $e->getMessage());
        }
        return false;
    }

    function createUpdateUsers($customer, $users) {
        $userIds = array_map(function($each){
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
            return $user->id;
        }, $users);

        $customer->users()->sync($userIds);
        return $userIds;
    }

    function createUpdateProjects($customer, $projects) {
        $projectIds = array_map(function($each){
            $project = Project::updateOrCreate(['id' => $each['id']],$each);
            return $project->id;
        }, $projects);

        $customer->projects()->sync($projectIds);
        return $projectIds;
    }

    function attachProjectParticipants($projectsIds, $usersIds) {
        foreach($projectsIds as $project_id) {
            foreach($usersIds as $user_id) {
                ProjectParticipant::updateOrCreate([
                    'user_id'       => $user_id,
                    'project_id'    => $project_id
                ]);
            }
        }
    }
}

?>
