<?php
namespace App\Repositories;

use App\Models\Customer;
use App\Models\User;
use App\Contracts\CustomerContract;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Http\Request;
use DataTableCollectionResource;

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

        $query = Customer::eloquentQuery($orderBy, $orderByDir, $searchValue);
        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

    function create($data) {
        $users = $data['users'];
        unset($data['users']);
        if($customer = parent::create($data)) {
            $this->createUpdateUsers($customer, $users);
            return $customer;
        }
        return false;
    }

    function update($data, $id) {
        $users = $data['users'];
        unset($data['users']);
        if(parent::update($data, $id)) {
            $customer = $this->findData($id);
            $this->createUpdateUsers($customer, $users);
            return $customer;
        }
        return false;
    }

    function createUpdateUsers($customer, $users) {
        $users = array_map(function($each){
            $password = '123456';
            $name = explode(' ', $each['name']);
            unset($each['name']);
            $user = array_merge([
                'first_name' => isset($name[0]) ? $name[0] : '',
                'last_name' => isset($name[1]) ? $name[1] : '',
                'password' => \Hash::make($password),
                'role'      => 'customer',
            ], $each);
            return new User($user);
        }, $users);

        $customer->users()->saveMany($users);
    }

}

?>
