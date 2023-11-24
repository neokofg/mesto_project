<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveKeyRequest;
use App\Http\Requests\GenerateKeyRequest;
use App\Http\Requests\UpdateResidentRequest;
use App\Models\Resident;
use App\Services\ResidentsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ResidentsController extends Controller
{
    public function __construct(private ResidentsService $residentsService)
    {

    }

    public function get()
    {
        $user = Auth::user();
        $response = $this->residentsService->get($user);
        if($response) {
            return response()->json(["message" => "Резиденты получены!", "status" => true, "residents" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_invitations()
    {
        $user = Auth::user();
        $response = $this->residentsService->get_invitations($user);
        if($response) {
            return response()->json(["message" => "Приглашения получены!", "status" => true, "residents" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function generate_key(GenerateKeyRequest $request)
    {
        $user = Auth::user();
        $response = $this->residentsService->generate_key($user, $request->all());
        if($response) {
            return response()->json(["message" => "Ключ получен!", "status" => true, "hash" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function approve_key(Request $request, $hash)
    {
        $response = $this->residentsService->approve_key($hash);
        if($response) {
            return response()->json(["message" => "Регистрация прошла успешно!", "status" => true, "credentials" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function decline_key(Request $request, $hash)
    {
        $response = $this->residentsService->decline_key($hash);
        if($response) {
            return response()->json(["message" => "Отклонено успешно!", "status" => true], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateResidentRequest $request)
    {
        $response = $this->residentsService->update($request->all());
        if($response) {
            return response()->json(["message" => "Обновлен успешно!", "status" => true], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(Request $request, $floor): JsonResponse
    {
        $res = Resident::where('floor', '=', $floor)->get();
        if($res) {
            return response()->json(["message" => "Получено!", "status" => true, "residents" => $res], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
