<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Show user info
     */
    public function index(User $user)
    {
        // TODO: implement retrieving user info.
    }

    /**
     * Handle registration of user request.
     *
     * @param Request $request
     */
    public function register(Request $request)
    {
        // TODO: implement user registration
    }

    /**
     * Handle editing user info request.
     *
     * @param Request $request
     */
    public function updateUserInfo(Request $request)
    {
        // TODO: implement user info editing
    }

    /**
     * Handle uploading user avatar request.
     *
     * @param Request $request
     */
    public function uploadAvatar(Request $request)
    {
        // TODO: implement uploading user Avatar
    }
}
