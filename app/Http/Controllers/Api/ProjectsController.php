<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Projects\AddProjectsRequest;
use App\Http\Requests\Api\Projects\UpdateProjectsRequest;
use App\Contracts\ProjectContract;
use App\Http\Resources\Api\ProjectResource;

class ProjectsController extends Controller
{
	private $projectService;

	public function __construct(ProjectContract $projectService)
	{
		$this->projectService = $projectService;
	}

	public function index(Request $request)
    {
		return $this->projectService->list($request);        
    }

	public function store(AddProjectsRequest $request)
	{
		$data = $request->all();

		$res  = $this->projectService->create($data);
		return $this->sendResponse($res);
	}

	public function update(UpdateProjectsRequest $request, $id)
	{
		$res  = $this->projectService->update($request->all(), $request->id);
		return $this->sendResponse($res);
	}

	public function show($id)
	{
		$res  = $this->projectService->show($id);
		return $this->sendResponse($res ? new ProjectResource($res) : []);
	}
}
