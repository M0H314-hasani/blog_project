<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsBriefResource;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;
use Validator;

class PostController extends Controller
{
    /**
     * Create a new PostController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'relatedPosts']]);
        $this->middleware('can:update,post', ['only' => ['update', 'changeStatus', 'changeAccessibility', 'uploadFeaturedImage']]);
    }

    /**
     * Retrieve all short info of posts ordered by date DESC and paginated.
     */
    public function index()
    {
        $posts = Post::whereIn('status', ['Published', 'Scheduled'])
            ->where('accessibility', 'Public')
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
     * Retrieve specific post
     *
     * @param Post $post
     */
    public function show(Post $post)
    {
        $responseData = [
            'message' => 'successfully_retrieved',
            'data' => $post
        ];

        return response()->json($responseData, 201);
    }

    /**
     * Handle the incoming request to create a post by current authenticated user.
     *
     */
    public function create()
    {
        $user = auth()->user();

        $post = new Post();
            $post->user_id = $user->id;
        $post->save();

        $responseData = [
            'message' => 'successfully_created',
            'data' => $post
        ];

        return response()->json($responseData, 201);
    }

    /**
     * Handle the request to editing a post
     *
     * @param Request $request
     */
    public function update(Post $post, Request $request)
    {
       $request->validate([
           'collection_id' => 'nullable|exists:collections,id',
           'title' => 'nullable|max:100',
           'subtitle' => 'nullable|max:255',
           'slug' => "nullable|min:3|unique:posts,slug,$post->id",
       ]);

       $post->update($request->all());

       $responseData = [
           'message' => 'successfully_updated',
           'data' => $post
       ];

       return response()->json($responseData, 200);
    }

    /**
     * Handle the request to changing status of a post.
     * accepted values: Published, Scheduled
     *
     * @param Request $request
     */
    public function changeStatus(Post $post, Request $request)
    {
        if($post->status == "Published" || ($post->status == "Scheduled" && Carbon::parse($post->published_at)->isBefore(now())))
        {
            $message = 'post_published_previously';
        }
        else {
            $request->validate([
                'status' => 'required|in:Publish,Schedule'
            ]);

            switch ($request->status) {
                case 'Publish':
                    // Validate the post that may can published or not.
                    Validator::make($post->toArray(), [
                        'collection_id' => 'required',
                        'title' => 'required',
                        'subtitle' => 'required',
                        'slug' => "required",
                        "featured_image" => "required",
                        "content" => "required",
                    ])->validate();

                    // Change status of post
                    $post->status = "Published";
                    $post->published_at = (string) now();
                    $post->save();

                    $message = 'successfully_published';

                    break;
                case 'Schedule':
                    $request->validate([
                        'published_at' => 'required'
                    ]);

                    // Validate the post that may can published or not.
                    Validator::make($post->toArray(), [
                        'collection_id' => 'required',
                        'title' => 'required',
                        'subtitle' => 'required',
                        'slug' => "required",
                        "featured_image" => "required",
                        "content" => "required",
                    ])->validate();

                    // Change status of post
                    $post->status = "Scheduled";
                    $post->published_at = $request->published_at;
                    $post->save();

                    $message = 'successfully_scheduled';

                    break;
            }
        }

        $responseData = [
            'message' => $message,
        ];

        return response()->json($responseData, 200);
    }

    /**
     * Handle the request to changing accessibility of a post.
     * accepted values: Private, Public
     *
     * @param Request $request
     */
    public function changeAccessibility(Post $post, Request $request)
    {
        $request->validate([
            'accessibility' => 'required|in:Private,Public'
        ]);

        $post->accessibility = $request->accessibility;
        $post->save();

        $responseData = [
            'message' => "successfully_updated",
        ];

        return response()->json($responseData, 200);
    }

    /**
     * Handle uploading featured image of a post request.
     *
     * @param Request $request
     */
    public function uploadFeaturedImage(Post $post, Request $request)
    {
        $request->validate([
            'featured_image' => 'required|image|max:5000'
        ]);

        // get old featured_image
        $oldFeaturedImage = str_replace('storage', 'public', $post->featured_image);

        // store featured_image
        $featuredImage = $request->file('featured_image');
        $featuredImageName = $featuredImage->hashName();
        $featuredImage->storeAs(Post::FEATURED_IMAGE_PATH, $featuredImageName);

        // update post featured_image
        $post->syncFeaturedImage($featuredImageName);

        // delete old featured_image
        Storage::delete($oldFeaturedImage);

        $responseData = [
            'message' => 'successfully_uploaded',
            'data' => $post->featured_image
        ];

        return response()->json($responseData, 200);
    }

    /**
     * Get related posts for a specific post.
     *
     * @param int $post
     */
    public function relatedPosts(Post $post, int $quantity)
    {
        $relatedPosts = Post::whereIn('status', ['Published', 'Scheduled'])
            ->where('accessibility', 'Public')
            ->whereRaw("IF (`status` = 'Scheduled', `published_at` < now(), `status` = 'Published')")
            ->where('collection_id', $post->collection_id)
            ->orderBy('updated_at', 'desc')
            ->limit($quantity)
            ->get();

        $responseData = [
            'message' => 'successfully_retrieved',
            'data' => $relatedPosts
        ];

        return response()->json($responseData, 200);
    }


}
