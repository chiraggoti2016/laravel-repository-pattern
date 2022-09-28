<?php
namespace App\Repositories;

use App\Models\Partner;
use App\Models\User;
use App\Contracts\PartnerContract;
use App\Http\Resources\Partner as PartnerResource;
use Illuminate\Http\Request;
use DataTableCollectionResource;
use DB;
use Log;

class PartnerRepository extends BaseRepository implements PartnerContract
{
    function __construct() {
        parent::__construct(new Partner);
    }

    function list(Request $request) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Partner::eloquentQuery($orderBy, $orderByDir, $searchValue)->withCount(['users','customers']);
        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

    function create($data) {
        DB::beginTransaction();
        try {
            $users = $data['users'];
            unset($data['users']);
            if($partner = parent::create($data)) {
                $this->createUpdateUsers($partner, $users);
                DB::commit();
                return $partner;
            }
        }catch(\Throwable $e){
            DB::rollBack();
            Log::debug('Partner Repository : ',[ 'error' =>$e ]);
            abort(404, $e->getMessage());
        }
        return false;
    }

    function update($data, $id) {
        DB::beginTransaction();
        try {
            $users = $data['users'];
            unset($data['users']);
            if(parent::update($data, $id)) {
                $partner = $this->findData($id);
                $this->createUpdateUsers($partner, $users);
                DB::commit();
                return $partner;
            }
        }catch(\Throwable $e){
            DB::rollBack();
            Log::debug('Partner Repository : ',[ 'error' =>$e ]);
            
            abort(404, $e->getMessage());
        }
        return false;
    }

    function createUpdateUsers($partner, $users) {
        $userIds = array_map(function($each){
            $password = '';
            $name = explode(' ', $each['name']);
            unset($each['name']);
            $userData = array_merge([
                'first_name' => isset($name[0]) ? $name[0] : '',
                'last_name' => isset($name[1]) ? $name[1] : '',
                'password' => \Hash::make($password),
            ], $each);
            $user = User::updateOrCreate(['id' =>$userData['id']],$userData);
            return $user->id;
        }, $users);

        $partner->users()->sync($userIds);
    }

}

?>
