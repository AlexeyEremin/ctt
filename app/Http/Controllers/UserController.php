<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginValidationRequest;
use App\Http\Requests\UserCreateValidation;
use App\Http\Resources\UserCampusesResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserShowResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Login
     * @param LoginValidationRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(LoginValidationRequest $request)
    {
        if(!Auth::attempt($request->validated()))
            return response('', 401);

        $user = Auth::user();
        $user->api_token = Str::uuid();
        $user->save();

        return response(['token' => $user->api_token], 200);
    }

    public function logout()
    {
        Auth::logout();
        return response([], 200);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function user()
    {
        return response(UserResource::make(Auth::user()));
    }

    public function show()
    {
        return response(UserResource::collection(Auth::user()->accounts));
    }

    public function campuses()
    {
        return response(UserCampusesResource::collection(Auth::user()->campuses));
    }

    public function create(UserCreateValidation $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->login = $request->login;
        $user->role = $request->role;
        $user->organization_id = Auth::user()->organization_id;
        $user->campus_id = $request->campus_id;
        $user->save();

        return response([], 201);
    }

    public function destroy(User $user)
    {
        return response(['status' => ($user->role == 'creator' ? false : true)]);
    }

    public function destroyDelete(User $user)
    {
        if($user->role == 'creator' || $user->organization_id != Auth::user()->organization_id)
            return response([], 403);
        $user->delete();

        return response([], 202);
    }
}
