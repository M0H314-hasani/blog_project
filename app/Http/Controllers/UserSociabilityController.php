<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSociabilityController extends Controller
{
    /**
     * Handle the incoming request to follow a user by current authenticated user.
     *
     * @param int $user
     */
    public function follow(int $user)
    {
        // TODO: implement following a user by current authenticated user.
    }

    /**
     * Handle the incoming request to unfollow a user by current authenticated user.
     *
     * @param int $user
     */
    public function unfollow(int $user)
    {
        // TODO: implement unfollowing a user by current authenticated user.
    }

    /**
     * Retrieve current authenticated user followers
     */
    public function followers()
    {
        // TODO: implement Retrieve current authenticated user followers action
    }

    /**
     * Retrieve current authenticated user followings
     */
    public function following()
    {
        // TODO: implement Retrieve current authenticated user followings action
    }
}
