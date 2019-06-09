<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;

class PostCollectionController extends Controller
{
    /**
     * Get all posts that there are in the specific collection.
     *
     * @param Collection $collection
     */
    public function retrieveCollectionOriented(Collection $collection)
    {
        // TODO: implement retrieving posts by collection oriented
    }

    /**
     * Get all posts that there are in collections of authenticated user.
     *
     */
    public function retrieveUserCollectionsOriented()
    {
        // TODO: implement retrieving posts by collections of authenticated user
    }
}
