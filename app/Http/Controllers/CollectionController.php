<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Retrieve all collections.
     */
    public function index()
    {
        // TODO: implement retrieve all collections action.
    }

    /**
     * Handle creation of collection by current authenticated user request.
     *
     * @param Request $request
     */
    public function create(Request $request)
    {
        // TODO: implement creation of collection by current authenticated user
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
        // TODO: implement destroying a collection
    }
}
