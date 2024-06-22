<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Get all category api
    */
    public function index()
    {
       $categories = Category::orderBy('id')->get();
       $categories = CategoryResource::collection($categories);
       return ResponseHelper::success($categories);
    }

}
