<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailApproveRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $response = $this->authService->register($request->all());
        if($response) {
            return response()->json(["message" => "Сообщение успешно отправлено!", "status" => true], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function register_approve(EmailApproveRequest $request): JsonResponse
    {
        $response = $this->authService->register_approve($request->all());
        if($response) {
            return response()->json(["message" => "Аккаунт успешно подтвержден!", "status" => true, "token" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
