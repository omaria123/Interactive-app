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
            'id'          => $this->id,
            'title'       => $this->title,
            'content'     => $this->content,
            'status'      => $this->status,
            'views_count' => $this->views_count,
            'author'      => [
                'id'    => $this->user->id ?? null,
                'name'  => $this->user->name ?? 'Неизвестен',
                'email' => $this->user->email ?? null,
            ],
            'tags'        => $this->tags->pluck('name'),
            'comments_count' => $this->comments->count(),
            'created_at'  => $this->created_at?->toIso8601String(),
        ];
    }
}
