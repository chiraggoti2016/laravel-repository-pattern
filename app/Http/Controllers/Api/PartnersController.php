<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Partners\AddPartnersRequest;
use App\Http\Requests\Api\Partners\UpdatePartnersRequest;
use App\Contracts\PartnerContract;
use App\Http\Resources\Api\PartnerResource;

class PartnersController extends Controller
{
	private $partnerService;

	public function __construct(PartnerContract $partnerService)
	{
		$this->partnerService = $partnerService;
	}

	public function index(Request $request)
	{
		return $this->partnerService->list($request);
	}

	public function store(AddPartnersRequest $request)
	{
		$data = $request->all();

		$res  = $this->partnerService->create($data);
		return $this->sendResponse($res);
	}

	public function update(UpdatePartnersRequest $request)
	{
		$res  = $this->partnerService->update($request->all(), $request->id);
		return $this->sendResponse($res);
	}

	public function show($id)
	{
		$res  = $this->partnerService->show($id);
		return $this->sendResponse(new PartnerResource($res));
	}

	public function destroy($id)
	{
		$res=$this->partnerService->delete($id);
		return $this->sendResponse($res);
    }
}
