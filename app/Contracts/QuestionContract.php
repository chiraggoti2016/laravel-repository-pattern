<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface QuestionContract extends BaseContract
{
	public function listByCategory($scope);
}
