<?php
namespace App\Repositories;

use App\Models\QuestionCategory;
use App\Contracts\QuestionCategoryContract;
use App\Http\Resources\QuestionCategory as QuestionCategoryResource;
use Illuminate\Http\Request;
use DataTableCollectionResource;
use DB;

class QuestionCategoryRepository extends BaseRepository implements QuestionCategoryContract
{
    function __construct() {
        parent::__construct(new QuestionCategory);
    }

    function list(Request $request) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = QuestionCategory::eloquentQuery($orderBy, $orderByDir, $searchValue);
        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }
}

?>
