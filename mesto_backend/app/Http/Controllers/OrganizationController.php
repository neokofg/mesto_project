<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        try {
            return response()->json(["message" => "Организации успешно получены!", "status" => true, "organizations" => Organization::all()], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}
