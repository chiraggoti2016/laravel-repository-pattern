<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Customers\AddCustomersRequest;
use App\Http\Requests\Api\Customers\UpdateCustomersRequest;
use App\Contracts\CustomerContract;
use App\Http\Resources\Api\CustomerResource;

class CustomersController extends Controller
{
	private $customerService;

	public function __construct(CustomerContract $customerService)
	{
		$this->customerService = $customerService;
	}

	public function index(Request $request)
	{
		return $this->customerService->list($request);
	}

	public function store(AddCustomersRequest $request)
	{
		$data = $request->all();

		$res  = $this->customerService->create($data);
		return $this->sendResponse($res);
	}

	public function update(UpdateCustomersRequest $request)
	{
		$res  = $this->customerService->update($request->all(), $request->id);
		return $this->sendResponse($res);
	}

	public function show($id)
	{
		$res  = $this->customerService->show($id);
		return $this->sendResponse(new CustomerResource($res));
	}

	public function destroy($id)
	{
		$res=$this->customerService->delete($id);
		return $this->sendResponse($res);
    }
}
