<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    //
    public function profile()
    {
        $user =new ProfileResource(Auth::user());
        return ResponseHelper::success($user);
    }

    /**
     * Profile posts
     */
    public function posts()
    {
        $posts = Post::where('user_id' , Auth::user()->id)
                ->orderByDesc('created_at')
                ->paginate(6);

        $posts =  PostResource::collection($posts);
        return ResponseHelper::success($posts);
    }
}
