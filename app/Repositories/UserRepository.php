<?php
namespace App\Repositories;

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

}

?>
