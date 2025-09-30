<?php

namespace App\Http\Controllers;

use App\Services\InternAttend\InternAttendService;
use Illuminate\Http\JsonResponse;

class InternAttendController extends Controller
{
    private $internAttendService;

    public function __construct(InternAttendService $internAttendService)
    {
        $this->internAttendService = $internAttendService;
    }

    public function index(): JsonResponse
    {
        return $this->internAttendService->getDataAttend()->toJson();
    }

    public function show($id): JsonResponse
    {
        return $this->internAttendService->getInternAttendById($id)->toJson();
    }

    public function store(): JsonResponse
    {
        return $this->internAttendService->createAttend()->toJson();
    }
    
    public function checkout(): JsonResponse
    {
        return $this->internAttendService->checkoutAttend()->toJson();
    }

    public function update($id): JsonResponse
    {
        return $this->internAttendService->updateAttend($id)->toJson();
    }

    public function destroy($id): JsonResponse
    {
        return $this->internAttendService->deleteInternAttendById($id)->toJson();
    }
}