<?php

namespace App\Http\Controllers\API\Auth;


use App\Common\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->only('name', 'email', 'password'));

        if ($user) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            return Response::success('Successfully registered', ['accessToken' => $token], 201);
        }

        return Response::error('Unable to register user', 400);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->authService->login($request->only('email', 'password'));

        if ($token) {
            return Response::success('Login successful', ['accessToken' => $token, 'token_type' => 'Bearer'], 201);
        }

        return Response::error('Unauthorized', 401);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return Response::success('Successfully logged out', [], 200);
    }

    public function user(Request $request)
    {
        return Response::success('User details retrieved successfully', $request->user(), 200);
    }
}
