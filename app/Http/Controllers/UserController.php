<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel 12 API Documentation",
 *      description="API Documentation for Laravel 12 Application",
 *      @OA\Contact(
 *          email="support@example.com"
 *      )
 * )
 *
 * @OA\Tag(
 *     name="User",
 *     description="Authentication Endpoints"
 * )
 */

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login User",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="test@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|longtokenhere"),
     *             @OA\Property(property="user", ref="#/components/schemas/UserResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->validate(User::rules());

        $result = $this->userRepository->login($credentials);

        return response()->json($result, $result['status']);
    }



    /**
         * @OA\Post(
         *     path="/api/register",
         *     summary="Register a new user",
         *     description="Register a new user and return the user data with token.",
         *     operationId="registerUser",
         *  
         *     tags={"User"},
         * 
         *     @OA\RequestBody(
         *         required=true,
         *         description="User registration data",
         *         @OA\JsonContent(
         *             required={"name", "email", "password", "password_confirmation"},
         *             @OA\Property(property="name", type="string", example="John Doe"),
         *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
         *             @OA\Property(property="password", type="string", format="password", example="password123"),
         *         )
         *     ),
         * 
         *     @OA\Response(
         *         response=201,
         *         description="User registered successfully",
         *         @OA\JsonContent(
         *             @OA\Property(property="user", type="object",
         *                 @OA\Property(property="id", type="integer", example=1),
         *                 @OA\Property(property="name", type="string", example="John Doe"),
         *                 @OA\Property(property="email", type="string", example="john@example.com"),
         *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T12:34:56Z"),
         *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T12:34:56Z")
         *             ),
         *             @OA\Property(property="token", type="string", example="1|abcdefghijk1234567890")
         *         )
         *     ),
         * 
         *     @OA\Response(
         *         response=422,
         *         description="Validation failed",
         *         @OA\JsonContent(
         *             @OA\Property(property="message", type="string", example="The given data was invalid."),
         *             @OA\Property(property="errors", type="object",
         *                 @OA\Property(property="email", type="array",
         *                     @OA\Items(type="string", example="The email field is required.")
         *                 )
         *             )
         *         )
         *     )
         * )
    */
    public function register(Request $request)
    {
        $credentials = $request->validate(User::registerRules());

        $result = $this->userRepository->register($credentials);

        return response()->json($result, $result['status']);
    }

    /**
         * @OA\Get(
         *     path="/api/user/{id}",
         *     summary="Get user by ID",
         *     description="Retrieve a user by their unique ID.",
         *     operationId="getUserById",
         *     tags={"User"},
         *     security={{"BearerToken":{}}},
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         description="ID of the user to retrieve",
         *         @OA\Schema(
         *             type="integer",
         *             example=1
         *         )
         *     ),
         * 
         *     @OA\Response(
         *         response=200,
         *         description="User data retrieved successfully",
         *         @OA\JsonContent(
         *             @OA\Property(property="id", type="integer", example=1),
         *             @OA\Property(property="name", type="string", example="John Doe"),
         *             @OA\Property(property="email", type="string", example="john@example.com"),
         *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-05T12:34:56Z"),
         *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-05T12:34:56Z")
         *         )
         *     ),
         * 
         *     @OA\Response(
         *         response=404,
         *         description="User not found",
         *         @OA\JsonContent(
         *             @OA\Property(property="message", type="string", example="User not found")
         *         )
         *     )
         * )
     */
    public function find(Request $request, int $id)
    {

        $result = $this->userRepository->find($id);

        return response()->json($result, $result['status']);
    }



    /**
         * @OA\Post(
         *     path="/api/auth/logout",
         *     summary="Logout the authenticated user",
         *     description="Revoke the current access token of the authenticated user.",
         *     operationId="logoutUser",
         *     tags={"User"},
         *     security={{"BearerToken":{}}},
         * 
         *     @OA\Response(
         *         response=200,
         *         description="Successfully logged out",
         *         @OA\JsonContent(
         *             @OA\Property(property="success", type="boolean", example=true),
         *             @OA\Property(property="message", type="string", example="Successfully logged out")
         *         )
         *     ),
         * 
         *     @OA\Response(
         *         response=401,
         *         description="User not authenticated",
         *         @OA\JsonContent(
         *             @OA\Property(property="success", type="boolean", example=false),
         *             @OA\Property(property="message", type="string", example="User not authenticated")
         *         )
         *     )
         * )
    */
    public function logout()
    {
        $result = $this->userRepository->logout();

        return response()->json($result, $result['status']);
    }
}
