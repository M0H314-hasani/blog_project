<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Retrieve all short info of posts ordered by date DESC and paginated.
     */
    public function index()
    {
        // TODO: implement retrieve all short info of posts ordered by date DESC and paginated.
    }

    /**
     * Retrieve specific post
     *
     * @param Post $post
     */
    public function show(Post $post)
    {
        // TODO: implement retrieve specific post action.
    }

    /**
     * Handle the incoming request to create a post by current authenticated user.
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        // TODO: implement creation of a post.
    }

    /**
     * Handle the request to editing a post
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        // TODO: implement updating a specific post.
    }

    /**
     * Handle the request to changing status of a post.
     * accepted values: Draft, Published, Scheduled
     *
     * @param Request $request
     */
    public function changeStatus(Request $request)
    {
        // TODO: implement changing status of a post action.
    }

    /**
     * Handle the request to changing accessibility of a post.
     * accepted values: Private, Public
     *
     * @param Request $request
     */
    public function changeAccessibility(Request $request)
    {
        // TODO: implement changing accessibility of a post.
    }

    /**
     * Handle uploading featured image of a post request.
     *
     * @param Request $request
     */
    public function uploadFeaturedImage(Request $request)
    {
        // TODO: implement uploading featured image
    }

    /**
     * Get related posts for a specific post.
     *
     * @param int $post
     */
    public function relatedPosts(int $post, int $quantity)
    {
        // TODO: implement retrieving related post for a post.
    }


}
