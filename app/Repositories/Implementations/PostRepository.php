<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{

    public function all(int $perPage = 10): array
    {
        $posts = Post::where('user_id', Auth::id())->with('user')
                    ->paginate($perPage);

        return [
            'success' => true,
            'posts' => PostResource::collection($posts)->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'last_page' => $posts->lastPage(),
            ],
            'status' => 200
        ];
    }

    public function find(int $id): array
    {
        $post = Post::with('user')->find($id);

        if (!$post) {
            return [
                'success' => false,
                'message' => 'Post not found',
                'status' => 404
            ];
        }

        return [
            'success' => true,
            'post' => new PostResource($post),
            'status' => 200
        ];
    }

    public function create(array $data): array
    {
        $data['user_id'] = Auth::id();
        $post = Post::create($data);
        // Loads the user relationship so PostResource can access it, 
        // for consistency purposes I intend to do this.
        $post->load('user');
        return [
            'success' => true,
            'post' => new PostResource($post),
            'message' => 'Post created successfully',
            'status' => 201
        ];
    }

    /**
     * Update an existing post.
     */
    public function update(array $data, int $id): array
    {
        $post = Post::find($id)->where('user_id', Auth::id())->with('user')->first();

        if (!$post) {
            return [
                'success' => false,
                'message' => 'Post not found',
                'status' => 404
            ];
        }

        $post->update($data);

        return [
            'success' => true,
            'post' => new PostResource($post),
            'message' => 'Post updated successfully',
            'status' => 200
        ];
    }

    public function delete(int $id): array
    {
        
        try {
            $post = Post::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            $post->delete();

            return [
                'success' => true,
                'message' => 'Post deleted successfully',
                'status' => 200
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'Post not found',
                'status' => 404
            ];
        }
    }
}
