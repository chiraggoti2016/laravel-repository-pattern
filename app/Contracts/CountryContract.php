<?php
namespace App\Contracts;

use Illuminate\Http\Request;

interface CountryContract extends BaseContract
{
	public function list(Request $request);
	
}
