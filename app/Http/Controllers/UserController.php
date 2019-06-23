<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'register']]);
    }

    /**
     * Show user info
     */
    public function index(User $user)
    {
        $responseData = [
            'message' => 'successfully_retrieve',
            'data' => $user
        ];

        return response()->json($responseData, 201);
    }

    /**
     * Handle registration of user request.
     *
     * @param Request $request
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:5|unique:users',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
        ]);
        $request->merge(['avatar' => 'default_avatar.png']);

        $user = new User();
            $user->username = $request->username;
            $user->password = $request->password;
            $user->email  = $request->email;
            $user->first_name  = $request->first_name;
            $user->last_name = $request->last_name;
            $user->avatar = $request->avatar;
        $user->save();

        $responseData = [
            'message' => 'successfully_created',
            'data' => $user
        ];

        return response()->json($responseData, 201);

    }

    /**
     * Handle editing user info request.
     *
     * @param Request $request
     */
    public function updateUserInfo(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => "required|min:5|unique:users,username,$user->id",
            'password' => 'required|min:8',
            'email' => "required|email|unique:users,username,$user->id",
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
        ]);

        $user->update($request->all());

        $responseData = [
            'message' => 'successfully_updated',
            'data' => $user
        ];

        return response()->json($responseData, 200);
    }

    /**
     * Handle uploading user avatar request.
     *
     * @param Request $request
     */
    public function uploadAvatar(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'avatar' => 'required|image|mimes:png|max:5000'
        ]);

        // get old avatar
        $oldAvatar = str_replace('storage', 'public', $user->avatar);

        // store avatar
        $avatar = $request->file('avatar');
        $avatarName = $avatar->hashName();
        $avatar->storeAs(User::AVATAR_PATH, $avatarName);

        // update user avatar
        $user->syncAvatar($avatarName);

        // delete old avatar
        Storage::delete($oldAvatar);

        $responseData = [
            'message' => 'successfully_uploaded',
            'data' => $user->avatar
        ];

        return response()->json($responseData, 200);

    }
}
