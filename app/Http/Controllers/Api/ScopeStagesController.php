<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\ScopeStageContract;

class ScopeStagesController extends Controller
{
	private $scopeStageService;

	public function __construct(ScopeStageContract $scopeStageService)
	{
		$this->scopeStageService = $scopeStageService;
	}

	public function listByScope(Request $request)
	{
		return $this->scopeStageService->listByScope();
	}

	public function listByScopeProject(Request $request, $project_id)
	{
		return $this->scopeStageService->listByScopeProject($project_id);
	}

}
