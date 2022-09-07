<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\ScopeContract;

class ScopesController extends Controller
{
	private $scopeService;

	public function __construct(ScopeContract $scopeService)
	{
		$this->scopeService = $scopeService;
	}

	public function listBySlug(Request $request)
	{
		return $this->scopeService->listBySlug();
	}

}
