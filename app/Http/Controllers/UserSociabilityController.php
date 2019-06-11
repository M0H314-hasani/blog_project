<?php

namespace App\Http\Controllers;

use App\User;

class UserSociabilityController extends Controller
{
    /**
     * Create a new UserSociabilityController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['follow']]);
    }


    /**
     * Handle the incoming request to follow & unfollow a user by current authenticated user.
     *
     * @param int $user
     */
    public function follow(int $leader)
    {
        $user = auth()->user();

        try {
            $result = $user->followings()->toggle($leader);
            if($result['attached']) {
                $message = 'successfully_followed';
            }
            elseif ($result['detached']) {
                $message = 'successfully_unfollowed';
            }

        } catch (\Exception $exception){
            $message = 'failed';
        }

        $responseData = [
            'message' => $message,
        ];

        return response()->json($responseData, 200);
    }

    /**
     * Retrieve current authenticated user followers
     */
    public function followers(User $user)
    {
        $followers = $user->followers;

        $responseData = [
            'message' => 'successfully_retrieved',
            'data' => $followers
        ];

        return response()->json($responseData, 200);

    }

    /**
     * Retrieve current authenticated user followings
     */
    public function following(User $user)
    {
        $followings = $user->followings;

        $responseData = [
            'message' => 'successfully_retrieved',
            'data' => $followings
        ];

        return response()->json($responseData, 200);
    }
}
