<?php
namespace App\Repositories;

use App\Models\Country;
use App\Contracts\CountryContract;
use Illuminate\Http\Request;
use DataTableCollectionResource;

class CountryRepository extends BaseRepository implements CountryContract
{
    function __construct() {
        parent::__construct(new Country);
    }

    function list(Request $request) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        
        $query = Country::eloquentQuery($orderBy, $orderByDir, $searchValue);
        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

}

?>
