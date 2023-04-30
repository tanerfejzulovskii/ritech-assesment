<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->resource->id,
            'title'      => $this->resource->title,
            'body'       => $this->resource->body,
            'author_id'  => $this->resource->author->name,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'updated_at' => $this->resource->updated_at->format('d-m-Y')
        ];
    }
}
