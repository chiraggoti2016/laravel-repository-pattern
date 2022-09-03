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

}

?>
