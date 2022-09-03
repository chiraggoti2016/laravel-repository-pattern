<?php
namespace App\Repositories;

use App\Models\Partner;
use App\Models\User;
use App\Contracts\PartnerContract;
use App\Http\Resources\Partner as PartnerResource;
use Illuminate\Http\Request;
use DataTableCollectionResource;

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

        $query = Partner::eloquentQuery($orderBy, $orderByDir, $searchValue);
        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

    function create($data) {
        $users = $data['users'];
        unset($data['users']);
        if($partner = parent::create($data)) {
            $this->createUpdateUsers($partner, $users);
            return $partner;
        }
        return false;
    }

    function update($data, $id) {
        $users = $data['users'];
        unset($data['users']);
        if(parent::update($data, $id)) {
            $partner = $this->findData($id);
            $this->createUpdateUsers($partner, $users);
            return $partner;
        }
        return false;
    }

    function createUpdateUsers($partner, $users) {
        $users = array_map(function($each){
            $password = '123456';
            $name = explode(' ', $each['name']);
            unset($each['name']);
            $user = array_merge([
                'first_name' => isset($name[0]) ? $name[0] : '',
                'last_name' => isset($name[1]) ? $name[1] : '',
                'password' => \Hash::make($password),
            ], $each);
            return new User($user);
        }, $users);

        $partner->users()->saveMany($users);
    }

}

?>
