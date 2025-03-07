<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

/**
 * @OA\Schema(
 *     schema="PostResource",
 *     type="object",
 *     title="Post Resource",
 *     description="Post resource representation",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="My First Post"),
 *     @OA\Property(property="content", type="string", example="This is the content of my post."),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-06T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-06T12:30:00Z"),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         ref="#/components/schemas/UserResource"
 *     )
 * )
 */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')), // Assuming 'user' relationship exists
        ];
    }
}