<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Questions\AddQuestionsRequest;
use App\Http\Requests\Api\Questions\UpdateQuestionsRequest;
use App\Contracts\QuestionContract;
use App\Http\Resources\Api\QuestionResource;

class QuestionsController extends Controller
{
	private $questionService;

	public function __construct(QuestionContract $questionService)
	{
		$this->questionService = $questionService;
	}

	public function index(Request $request)
	{
		return $this->questionService->list($request);
	}

	public function store(AddQuestionsRequest $request)
	{
		$data = $request->all();

		$res  = $this->questionService->create($data);
		return $this->sendResponse($res);
	}

	public function update(UpdateQuestionsRequest $request)
	{
		$res  = $this->questionService->update($request->all(), $request->id);
		return $this->sendResponse($res);
	}

	public function show($id)
	{
		$res  = $this->questionService->show($id);
		return $this->sendResponse(new QuestionResource($res));
	}

	public function destroy($id)
	{
		$res=$this->questionService->delete($id);
		return $this->sendResponse($res);
    }
}
