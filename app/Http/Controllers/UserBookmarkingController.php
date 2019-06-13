<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class UserBookmarkingController extends Controller
{
    /**
     * Create a new UserBookmarkingController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Add a post to bookmark list for the current authenticated user.
     *
     * @param int $post
     */
    public function bookmarkPost(int $post)
    {
        $user = auth()->user();

        try {
            $result = $user->bookmarked_posts()->toggle($post);
            if($result['attached']) {
                $message = 'successfully_bookmarked';
            }
            elseif ($result['detached']) {
                $message = 'successfully_remove_from_bookmark';
            }

        } catch (\Exception $exception) {
            $message = 'failed';
        }

        $responseData = [
            'message' => $message,
        ];

        return response()->json($responseData, 200);
    }

    /**
     * Retrieve bookmarked post of current authenticated user.
     */
    public function bookmarkedPosts()
    {
        $user = auth()->user();

        $bookmarkedPosts = $user->bookmarked_posts;

        $responseData = [
            'message' => 'successfully_retrieve',
            'data' =>$bookmarkedPosts
        ];

        return response()->json($responseData, 200);
    }
}
