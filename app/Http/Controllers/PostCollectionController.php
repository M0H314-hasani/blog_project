<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Http\Resources\PostsBriefResource;
use App\Post;
use Illuminate\Http\Request;

class PostCollectionController extends Controller
{
    /**
     * Create a new PostCollectionController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['retrieveUserCollectionsOriented']]);
    }

    /**
     * Get all posts that there are in the specific collection.
     *
     * @param int $collection
     */
    public function retrieveCollectionOriented(int $collection)
    {
        $posts = Post::whereIn('status', ['Published', 'Scheduled'])
            ->where('accessibility', 'Public')
            ->where('collection_id', $collection)
            ->whereRaw("IF (`status` = 'Scheduled', `published_at` < now(), `status` = 'Published')")
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $posts->data = PostsBriefResource::collection($posts);

        $responseData = [
            'message' => 'successfully_retrieved',
            'data' => $posts
        ];

        return response()->json($responseData, 200);
    }

    /**
     * Get all posts that there are in collections of authenticated user.
     *
     */
    public function retrieveUserCollectionsOriented()
    {
        $user = auth()->user();
        $collections_ids = $user->following_collections->pluck('id')->toArray();

        $posts = Post::whereIn('status', ['Published', 'Scheduled'])
            ->where('accessibility', 'Public')
            ->whereIn('collection_id', $collections_ids)
            ->whereRaw("IF (`status` = 'Scheduled', `published_at` < now(), `status` = 'Published')")
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $posts->data = PostsBriefResource::collection($posts);

        $responseData = [
            'message' => 'successfully_retrieved',
            'data' => $posts
        ];

        return response()->json($responseData, 200);
    }
}
