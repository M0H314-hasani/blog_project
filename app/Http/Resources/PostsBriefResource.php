<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsBriefResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "subtitle" => $this->subtitle,
            "slug" => $this->slug,
            "likes" => $this->likes,
            "featured_image" => $this->featured_image,
        ];
    }
}
