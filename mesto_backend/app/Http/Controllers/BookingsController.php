<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingCreateRequest;
use App\Http\Requests\BookingGetRequest;
use App\Http\Requests\BookingIndexRequest;
use App\Http\Requests\BookingsAcceptRequest;
use App\Http\Requests\BookingUpdateRequest;
use App\Models\Booking;
use App\Models\Excursion;
use App\Services\BookingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BookingsController extends Controller
{
    public function __construct(private BookingsService $bookingsService)
    {

    }

    public function create(BookingCreateRequest $request)
    {
        $response = $this->bookingsService->create($request->all());
        if($response) {
            return response()->json(["message" => "Создан успешно!", "status" => true], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get(BookingGetRequest $request)
    {
        $response = $this->bookingsService->get($request->all());
        if($response) {
            return response()->json(["message" => "Запись найдена!", "status" => true, "booking" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index(BookingIndexRequest $request)
    {
        $response = $this->bookingsService->index($request->all());
        if($response) {
            return response()->json(["message" => "Записи найдены!", "status" => true, "bookings" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(BookingUpdateRequest $request)
    {
        $response = $this->bookingsService->update($request->all());
        if($response) {
            return response()->json(["message" => "Запись обновлена!", "status" => true], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function accept(BookingsAcceptRequest $request)
    {
        $response = $this->bookingsService->accept($request->all());
        if($response) {
            return response()->json(["message" => "Записи подтверждены!", "status" => true], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function excursions(Request $request)
    {
        $response = Excursion::where("organization_id",'=',Auth::user()->organization()->first()->id)->get();
        if($response) {
            return response()->json(["message" => "Экскурсии получены!", "status" => true, "excursions" => $response], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Произошла ошибка!", "status" => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
