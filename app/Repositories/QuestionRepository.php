<?php
namespace App\Repositories;

use App\Models\Question;
use App\Contracts\QuestionContract;
use App\Http\Resources\Question as QuestionResource;
use Illuminate\Http\Request;
use DataTableCollectionResource;
use DB;

class QuestionRepository extends BaseRepository implements QuestionContract
{
    function __construct() {
        parent::__construct(new Question);
    }

    function list(Request $request) {
        $length = $request->input('length');
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Question::eloquentQuery($orderBy, $orderByDir, $searchValue);
        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

}

?>
