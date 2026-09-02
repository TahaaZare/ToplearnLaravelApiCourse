<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\RegisterApiRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(RegisterApiRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $newUser = User::create($validated);

        //create token
        $token = $newUser->createToken("{$newUser->email}-register-token",["*"],now()->addDays(30))->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
        ], 200);
    }

    public function login(LoginApiRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Wrong password',
            ], 403);
        }

        //delete tokens
//        $user->tokens()->delete();
        $user->tokens()->where('name', "{$user->email}-register-token")->delete();

        //create token
        $token = $user->createToken("{$user->email}-login-token")->plainTextToken;
        return response()->json([
            'message' => 'User login successfully',
            'token' => $token,
        ], 200);
    }
}
