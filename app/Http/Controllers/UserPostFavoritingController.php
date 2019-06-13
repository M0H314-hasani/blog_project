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
        $user = auth()->user();

        try {
            $result = $user->liked_posts()->toggle($post);
            if($result['attached']) {
                $message = 'successfully_liked';
            }
            elseif ($result['detached']) {
                $message = 'successfully_disliked';
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
     * Retrieve liked post of current authenticated user.
     */
    public function likedPosts()
    {
        $user = auth()->user();

        $likedPosts = $user->liked_posts;

        $responseData = [
            'message' => 'successfully_retrieve',
            'data' =>$likedPosts
        ];

        return response()->json($responseData, 200);
    }
}
