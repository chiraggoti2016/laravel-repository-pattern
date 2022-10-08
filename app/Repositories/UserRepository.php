<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\User;
use App\Contracts\UserContract;
use App\Http\Resources\User as UserResource;

class UserRepository extends BaseRepository implements UserContract
{
    function __construct() {
        parent::__construct(new User);
    }

    public function resend(Request $request, $user)
    {
        if ($user->hasVerifiedEmail()) {

            return ['message' => 'User already have verified email!', 'status' => 422];

        }

        $request->user()->sendEmailVerificationNotification();

        return ['message' => 'The notification has been resubmitted'];
    }

    public function changePassword(Request $request)
    {

        if (!(\Hash::check($request->get('old_password'), \Auth::user()->password))) {
            // The passwords matches
            abort(422, 'Your current password does not matches with the password.');
        } else if(strcmp($request->get('old_password'), $request->get('new_password')) == 0){
            // Current password and new password same
            abort(422, 'New Password cannot be same as your current password.');
        } else {

            $user = \Auth::user();

            if( $user ) {
                $user->update([
                    'password'  => \Hash::make($request->new_password),
                ]);
                return ['message' => 'password has been changed', 'status' => 200];    
            }
    
            abort(422, 'try again later.');
        }

    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::find($id);

        if( $user ) {
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }
            $user->update([
                'password'  => \Hash::make($request->password),
            ]);
            return ['message' => 'password has been changed', 'status' => 200];    
        }

        abort(422, 'try again later.');

    }

}

?>
