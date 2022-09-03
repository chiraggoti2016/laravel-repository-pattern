<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface CustomerContract extends BaseContract
{
	public function list(Request $request);
}
