<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserInfoApiResource;
use App\Http\Resources\Api\UserListApiResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function list()
    {
        $users = User::paginate(2);

        return response()->json([
            'message' => 'data fetched',
            'data' => [
                'users' => UserListApiResource::collection($users),
                'current_page' => $users->currentPage(),
                'next_page_url' => $users->nextPageUrl(),
                'prev_page_url' => $users->previousPageUrl(),
            ]
        ],200);
    }
    public function info()
    {
        return response()->json([
            'message' => 'data fetched',
            'data' => new UserInfoApiResource(auth()->user())
        ],200);
    }
}

