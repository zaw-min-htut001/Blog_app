<?php

namespace App\Models;

use App\Models\User;
use App\Models\Media;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->morphOne(Media::class, 'model');
    }
    /**
     * filters & search Logic codes
     */
    public function scopeFilter($query , $filter)
    {
        if(isset($filter['category']))
        {
            $query->whereHas('category' , function ($cateQuery) use ($filter) {
                $cateQuery->where('name', $filter['category']);
            });
        };

        if(isset($filter['searchKey']))
        {
            $query->where(function ($searchQuery) use ($filter) {
            $searchQuery->where('title' , 'like' , '%' . $filter['searchKey'] . '%')
                ->orWhere('description' , 'like' , '%' . $filter['searchKey'] . '%');
            });
        };
    }
}
