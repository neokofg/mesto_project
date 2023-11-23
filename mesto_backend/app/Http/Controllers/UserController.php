<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {

    }

    public function get()
    {
        $response = $this->userService->get();
        if($response) {
            return response()->json(["message" => "Пользователь получен!", "status" => true, "user" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UserUpdateRequest $request)
    {
        $user = Auth::user();
        $response = $this->userService->update($user, $request->all());
        if($response) {
            return response()->json(["message" => "Пользователь обновлен!", "status" => true, "user" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
