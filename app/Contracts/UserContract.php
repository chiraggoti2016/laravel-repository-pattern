<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface UserContract extends BaseContract
{
    public function resend(Request $request, $user);	
}
