<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Questionaires\SendQuestionairesRequest;
use App\Contracts\QuestionaireContract;
use App\Http\Resources\Api\QuestionaireResource;

class QuestionairesController extends Controller
{
	private $questionaireService;

	public function __construct(QuestionaireContract $questionaireService)
	{
		$this->questionaireService = $questionaireService;
	}

	public function send(SendQuestionairesRequest $request, $project_id)
	{
		$res  = $this->questionaireService->send($request->all(), $project_id);
		return $this->sendResponse($res ? new QuestionaireResource($res) : $res);
	}

}
