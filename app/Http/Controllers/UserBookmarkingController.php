<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class UserBookmarkingController extends Controller
{
    /**
     * Add a post to bookmark list for the current authenticated user.
     *
     * @param int $post
     */
    public function bookmarkPost(int $post)
    {
        // TODO: implement Add a post to bookmark list for the current authenticated user
    }

    /**
     * Retrieve bookmarked post of current authenticated user.
     */
    public function bookmarkedPosts(User $user)
    {
        // TODO: implement retrieve bookmarked post of current authenticated user
    }
}
