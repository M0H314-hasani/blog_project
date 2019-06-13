<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPostFavoritingController extends Controller
{
    /**
     * Create a new UserPostFavoritingController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * like & dislike a post by the current authenticated user.
     *
     * @param int $post
     */
    public function likePost(int $post)
    {
        // TODO: implementation of like & dislike action
    }

    /**
     * Retrieve bookmarked post of current authenticated user.
     */
    public function likedPosts()
    {
        // TODO: implementation of retrieved liked post by current authenticated user
    }
}
