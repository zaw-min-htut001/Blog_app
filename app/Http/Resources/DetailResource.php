<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'category_name' => $this->category->name,
            'owner_name' => $this->user->name,
            'created_at' => Carbon::parse($this->created_at)->locale('my_MM')->diffForHumans(),
            'updated_at' => $this->updated_at,
            'image_path' => asset($this->image->file_name)
        ];
    }
}
