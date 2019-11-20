<?php

namespace App\http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param Request $request
     * @return Response
     *
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try
        {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($request->input('password'));
            $user->save();

            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } 
        catch (\Exception $e) 
        {
            return response()->json(['message' => 'User Registration Failed'], 409);
        }
    }


    /**
     * Get a JWT via given credentials
     * 
     * @param Request $request
     * @return Response
     * 
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email','password']);

        if (! $token = Auth::attempt($credentials) )
        {
            return response()->json(['message' => 'Unautorized'], 401);
        }

        return $this->respondWithToken($token);
    }
}
