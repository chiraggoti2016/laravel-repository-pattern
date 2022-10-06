<?php
namespace App\Contracts;
use Illuminate\Http\Request;

interface UserContract extends BaseContract
{
    public function resend(Request $request, $user);	
    public function changePassword(Request $request);	
    
}
