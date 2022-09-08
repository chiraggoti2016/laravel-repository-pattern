<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface ProjectContract extends BaseContract
{
    public function list(Request $request);
}
