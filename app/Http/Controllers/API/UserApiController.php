<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CustomQueryException;
use App\Exceptions\CustomValidationException;
use App\Helpers\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws CustomValidationException
     * @throws CustomQueryException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return CustomResponse::successResponse('success',
            new UserResource($this->userService->register($request->validated())), 201);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws CustomValidationException
     * @throws CustomQueryException|AuthenticationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return CustomResponse::successResponse('success',
            new UserResource($this->userService->login($request->validated())), 200);
    }

    /**
     * @throws CustomQueryException
     */
    public function list(): JsonResponse
    {
        return CustomResponse::successResponse('success',
            UserResource::collection($this->userService->list()));
    }
}
