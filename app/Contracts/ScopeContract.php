<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface ScopeContract extends BaseContract
{
	public function listBySlug();
    
}
