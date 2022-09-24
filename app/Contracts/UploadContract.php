<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface UploadContract extends BaseContract
{
    public function file(Request $request);	
}
