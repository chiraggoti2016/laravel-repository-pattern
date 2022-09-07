<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Countries\AddCountriesRequest;
use App\Http\Requests\Api\Countries\UpdateCountriesRequest;
use App\Contracts\CountryContract;
use App\Http\Resources\Api\CountryResource;

class CountriesController extends Controller
{
	private $countryService;

	public function __construct(CountryContract $countryService)
	{
		$this->countryService = $countryService;
	}

	public function index(Request $request)
	{
		return $this->countryService->all();
	}

    public function list(Request $request)
	{
		return $this->countryService->list($request);
	}

	public function store(AddCountriesRequest $request)
	{
		$data = $request->all();

		$res  = $this->countryService->create($data);
		return $this->sendResponse($res);
	}

	public function update(UpdateCountriesRequest $request)
	{
		$res  = $this->countryService->update($request->all(), $request->id);
		return $this->sendResponse($res);
	}

	public function show($id)
	{
		$res  = $this->countryService->show($id);
		return $this->sendResponse(new CountryResource($res));
	}

	public function destroy($id)
	{
		$res=$this->countryService->delete($id);
		return $this->sendResponse($res);
    }
}
