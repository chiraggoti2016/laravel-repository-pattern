<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Projects\AddProjectsRequest;
use App\Http\Requests\Api\Projects\UpdateProjectsRequest;
use App\Contracts\ProjectContract;
use App\Http\Resources\Api\ProjectResource;
use App\Models\Project;

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

	public function hosts(Request $request, $slug) {
		return $this->projectService->hosts($request, $slug);
	}

	public function hostdetails(Request $request, $slug) {
		return $this->projectService->hostdetails($request, $slug);
	}

	public function databasedetails(Request $request, $slug, $host_id) {
		return $this->projectService->databasedetails($request, $slug, $host_id);
	}
	
	public function specificdatabasedetails(Request $request, $database_id) {
		return $this->projectService->specificdatabasedetails($request, $database_id);
	}

	public function specificdatabasefeaturedetails(Request $request, $database_id) {
		return $this->projectService->specificdatabasefeaturedetails($request, $database_id);
	}
}
