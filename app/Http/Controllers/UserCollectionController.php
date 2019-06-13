<?php

namespace App\Http\Controllers;

use App\Collection;
use Illuminate\Http\Request;

class UserCollectionController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Retrieve all collections that created by current authenticated user.
     */
    public function userCollections()
    {
        $user = auth()->user();

        $collections = $user->collections;

        $responseData = [
            'message' => 'successfully_retrieve',
            'data' =>$collections
        ];

        return response()->json($responseData, 200);
    }

    /**
     * Handle the incoming request to follow a collection by current authenticated user.
     *
     * @param int $collection
     */
    public function followCollection(Collection $collection)
    {
        $user = auth()->user();

        try {
            $result = $user->following_collections()->toggle($collection->id);
            if($result['attached']) {
                $message = 'successfully_followed';
                $collection->followers ++;
            }
            elseif ($result['detached']) {
                $message = 'successfully_unfollowed';
                $collection->followers --;
            }

            $collection->save();

        } catch (\Exception $exception){
            $message = 'failed';
        }

        $responseData = [
            'message' => $message,
        ];

        return response()->json($responseData, 200);
    }

    /**
     * Retrieve all collection which followed by current authenticated user.
     */
    public function followedCollections()
    {
        $user = auth()->user();

        $userCollections = $user->following_collections;

        $responseData = [
            'message' => 'successfully_retrieve',
            'data' =>$userCollections
        ];

        return response()->json($responseData, 200);
    }
}
