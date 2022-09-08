<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\QuestionCategories\AddQuestionCategoriesRequest;
use App\Http\Requests\Api\QuestionCategories\UpdateQuestionCategoriesRequest;
use App\Contracts\QuestionCategoryContract;
use App\Http\Resources\Api\QuestionCategoryResource;

class QuestionCategoriesController extends Controller
{
	private $questionCategoryService;

	public function __construct(QuestionCategoryContract $questionCategoryService)
	{
		$this->questionCategoryService = $questionCategoryService;
	}

	public function index(Request $request)
	{
		return $this->questionCategoryService->all();
	}

    public function list(Request $request)
	{
		return $this->questionCategoryService->list($request);
	}

	public function store(AddQuestionCategoriesRequest $request)
	{
		$data = $request->all();

		$res  = $this->questionCategoryService->create($data);
		return $this->sendResponse($res);
	}

	public function update(UpdateQuestionCategoriesRequest $request)
	{
		$res  = $this->questionCategoryService->update($request->all(), $request->id);
		return $this->sendResponse($res);
	}

	public function show($id)
	{
		$res  = $this->questionCategoryService->show($id);
		return $this->sendResponse(new QuestionCategoryResource($res));
	}

	public function destroy($id)
	{
		$res=$this->questionCategoryService->delete($id);
		return $this->sendResponse($res);
    }
}
