<?php

namespace App\Repositories\Implementations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Resources\UserResource;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository implements UserRepositoryInterface
{
    public function register(array $data): array
    {
        try {
            $user = User::create($data);
            SendWelcomeEmailJob::dispatch($user);
            return [
                'success' => true,
                'user' => new UserResource($user),
                'status' => 200
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Internal Server Error',
                'status' => 500
            ];
        }
    }

    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials',
                'status' => 401
            ];
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'success' => true,
            'user' => new UserResource($user),
            'token' => $token,
            'status' => 200
        ];
    }

    public function logout(): array
    {
        $user = Auth::user();

        if ($user) {
            // Revoke the current access token
            $user->currentAccessToken()->delete();

            return [
                'success' => true,
                'message' => 'Successfully logged out',
                'status' => 200
            ];
        }

        return [
            'success' => false,
            'message' => 'User not authenticated',
            'status' => 401
        ];
    }

    public function find(int $id): array
    {
        
        try {
            $user = User::findOrFail($id);
            
            return [
                'success' => true,
                'user' => new UserResource($user),
                'status' => 200
            ];
        } catch (ModelNotFoundException $e) {
            return [
                'success' => false,
                'message' => 'User not found',
                'status' => 404
            ];
        }
    }
}