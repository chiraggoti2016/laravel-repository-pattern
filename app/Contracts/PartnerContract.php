<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface PartnerContract extends BaseContract
{
	public function list(Request $request);
}
