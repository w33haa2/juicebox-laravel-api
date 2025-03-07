<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;


use App\Repositories\Contracts\PostRepositoryInterface;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="Endpoints for managing posts"
 * )
 */
class PostController extends Controller
{
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
         * List paginated posts for the authenticated user.
         *
         * @OA\Get(
         *     path="/api/posts",
         *     tags={"Posts"},
         *     security={{"BearerToken":{}}},
         *     @OA\Parameter(
         *         name="per_page",
         *         in="query",
         *         required=false,
         *         description="Number of items per page (default 10)",
         *         @OA\Schema(type="integer", example=10)
         *     ),
         *     @OA\Parameter(
         *         name="page",
         *         in="query",
         *         required=false,
         *         description="Page number (default 1)",
         *         @OA\Schema(type="integer", example=1)
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="List of posts with pagination",
         *         @OA\JsonContent(
         *             type="object",
         *             @OA\Property(property="success", type="boolean", example=true),
         *             @OA\Property(property="posts", type="array",
         *                 @OA\Items(ref="#/components/schemas/PostResource")
         *             ),
         *             @OA\Property(property="pagination", type="object",
         *                 @OA\Property(property="current_page", type="integer", example=1),
         *                 @OA\Property(property="last_page", type="integer", example=5),
         *                 @OA\Property(property="per_page", type="integer", example=10),
         *                 @OA\Property(property="total", type="integer", example=50),
         *                 @OA\Property(property="next_page_url", type="string", nullable=true, example="http://localhost/api/posts?page=2"),
         *                 @OA\Property(property="prev_page_url", type="string", nullable=true, example=null)
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthenticated"
         *     )
         * )
    */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Default to 10 per page
        $result = $this->postRepository->all($perPage);

        return response()->json($result, $result['status']);
    }

    /**
         * Get details of a single post.
         *
         * @OA\Get(
         *     path="/api/posts/{id}",
         *     tags={"Posts"},
         *     security={{"BearerToken":{}}},
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Post ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Post details"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Post not found"
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthenticated"
         *     )
        * )
     */
    public function show(int $id)
    {
        $result = $this->postRepository->find($id);
        return response()->json($result, $result['status']);
    }

     /**
         * Create a new post.
         *
         * @OA\Post(
         *     path="/api/posts",
         *     tags={"Posts"},
         *     security={{"BearerToken":{}}},
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"title", "content"},
         *             @OA\Property(property="title", type="string", example="My First Post"),
         *             @OA\Property(property="content", type="string", example="This is the content of my first post.")
         *         )
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="Post created successfully"
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Validation error"
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthenticated"
         *     )
         * )
     */
    public function store(Request $request)
    {
        $data = $request->validate(Post::rules());

        $result = $this->postRepository->create($data);
        return response()->json($result, $result['status']);
    }

    /**
         * Update an existing post.
         *
         * @OA\Patch(
         *     path="/api/posts/{id}",
         *     tags={"Posts"},
         *     security={{"BearerToken":{}}},
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Post ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             @OA\Property(property="title", type="string", example="Updated Title"),
         *             @OA\Property(property="content", type="string", example="Updated content for the post.")
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Post updated successfully"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Post not found"
         *     ),
         *     @OA\Response(
         *         response=422,
         *         description="Validation error"
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthenticated"
         *     )
         * )
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate(Post::rules());

        $result = $this->postRepository->update($data, $id);
        return response()->json($result, $result['status']);
    }

    /**
         * Delete a post.
         *
         * @OA\Delete(
         *     path="/api/posts/{id}",
         *     tags={"Posts"},
         *     security={{"BearerToken":{}}},
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="Post ID",
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Post deleted successfully"
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Post not found"
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Unauthenticated"
         *     )
         * )
     */
    public function destroy(int $id)
    {
        $result = $this->postRepository->delete($id);
        return response()->json($result, $result['status']);
    }
}
