<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserCollectionController extends Controller
{
    /**
     * Handle the incoming request to follow a collection by current authenticated user.
     *
     * @param int $collection
     */
    public function followCollection(int $collection)
    {
        // TODO: implement follow a collection by current authenticated user action
    }

    /**
     * Retrieve all collection which followed by current authenticated user.
     */
    public function followedCollections()
    {
        // TODO: implement retrieving all collection which followed by current authenticated user.
    }
}
