<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface ScopeStageContract extends BaseContract
{
	public function listByScope();
	public function listByScopeProject($project_id);
    
}
