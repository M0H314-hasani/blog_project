<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;
use Str;


class CollectionController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->middleware('can:delete,collection', ['only' => ['destroy']]);
    }

    /**
     * Retrieve all collections.
     */
    public function index()
    {
        $collections = Collection::all();

        $responseData = [
            'message' => 'successfully_retrieved',
            'data' => $collections
        ];

        return response()->json($responseData, 201);
    }

    /**
     * Handle creation of collection by current authenticated user request.
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|min:3|unique:collections',
            'subtitle' => 'required|max:255',
            'slug' => 'required|min:3|unique:collections',
        ]);

        $collection = new Collection();
            $collection->user_id = $user->id;
            $collection->name = $request->name;
            $collection->subtitle = $request->subtitle;
            $collection->slug = Str::slug($request->slug, '-');
        $collection->save();

        $responseData = [
            'message' => 'successfully_created',
            'data' => $collection
        ];

        return response()->json($responseData, 201);


    }

    /**
     * Destroying a collection.
     * This action should be perform by the same user that create this collection. (ACL)
     * The collection that has some related posts can't destroy!
     *
     * @param Collection $collection
     */
    public function destroy(Collection $collection)
    {
        if ($collection->posts->count())
            $status = false;
        else
            $status = $collection->delete();

        $responseData = [
            'message' => $status ? 'successfully_deleted' : 'failed_to_delete',
        ];

        return response()->json($responseData, 200);

    }
}
