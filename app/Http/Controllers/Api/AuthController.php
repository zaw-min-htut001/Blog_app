<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
     /***
     * api/register
     * create Token after Register
    */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:20'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        $token = $user->createToken('Blog')->plainTextToken;

        return ResponseHelper::success([
            'token' => $token,
        ]);
    }

    /***
     * api/login
    */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:20'
        ]);

        if (Auth::attempt(['email' => $request->email,
            'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('Blog')->plainTextToken;

            return ResponseHelper::success([
                'token' => $token,
            ]);
        }

    }
    /**
     * logout Api
     */
    public function logout()
    {
        $user =Auth::user();
        $user->currentAccessToken()->delete();
        return ResponseHelper::success([]);
    }
}
