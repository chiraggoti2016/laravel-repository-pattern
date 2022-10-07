<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Str;
use Mail;

class VerifyController extends Controller
{
    public function verify($token, Request $request)
    {
        // if (!$request->hasValidSignature()) {
        //     return redirect('/admin/login?verification_status=error');
        // }

        $user = User::whereHas('user_verify', function($q) use($token){
            return $q->where('token', $token);
        })->first();

        if ($user && !$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            $password = Str::random(8);

            $user->update(['password' => \Hash::make($password)]);

            dispatch(new \App\Jobs\NewPasswordMailJob($user->email, ['user' => $user, 'password' => $password]));
        }

        return redirect('/admin/login?verification_status=success');
    }

    public function resend(User $user)
    {
        if (!$user) {
            return response()->json(["message" => "Invalid user."], 400);
        } elseif ($user->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 422);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["message" => "Please check your email to complete verification."]);
    }
}
