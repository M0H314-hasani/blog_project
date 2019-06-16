<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPostController extends Controller
{
    /**
     * Create a new UserPostController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Retrieve all posts that created by current authenticated user.
     */
    public function userPosts()
    {
        $user = auth()->user();

        $posts = $user->posts;

        $responseData = [
            'message' => 'successfully_retrieve',
            'data' =>$posts
        ];

        return response()->json($responseData, 200);
    }
}
