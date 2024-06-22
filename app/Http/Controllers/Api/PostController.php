<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Post;
use App\Models\Media;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DetailResource;

class PostController extends Controller
{
    /**
     * GET ALL POST API
     */
    public function index()
    {
        $posts = Post::filter(request(['category' ,'searchKey']))
                ->orderByDesc('created_at')
                ->paginate(6);

        $posts =  PostResource::collection($posts);
        return ResponseHelper::success($posts);
    }
    /*
    * create post api
    */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required' ,
            'category_id' => 'required'
        ],
        [
            'category_id.required' => 'The category field is required'
        ]);
        /**
         * DB transaction
         */
        DB::beginTransaction();
        try {
        if($request->hasFile('file_name')){
            $file = $request->file('file_name');
            $extension = $file->getClientOriginalExtension();
            $filename  = '-image-' . time() . '.' . $extension;
            $imagePath = $file->storeAs('/Blog', $filename);
        }
        $post = new Post();
        $post->title = $request->title;
        $post->user_id =Auth::user()->id;
        $post->description = $request->description;
        $post->category_id = $request->category_id;
        $post->save();

        $media = new Media();
        $media->file_name = 'storage/' . $imagePath;
        $media->file_type = 'image';
        $media->model_id = $post->id;
        $media->model_type = Post::class;
        $media->save();

        DB::commit();
        return ResponseHelper::success([]);
        } catch (Exception $e){
            DB::rollback();
            return ResponseHelper::fail($e->getMessage());
        }
    }

    /**
     * show Api
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post = new DetailResource($post);
        return ResponseHelper::success($post);
    }

    /**
     * Delete Api
     */
    public function destory($id)
    {
        $post = Post::find($id);
        $post->delete();
        return ResponseHelper::success([], 'Deleted Success!');
    }
}
