<?php

namespace App\Http\Controllers;

use App\Services\CoD\CoDService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CoDController extends Controller
{
    private $CoDService;

    public function __construct(CoDService $coDService)
    {
        $this->CoDService = $coDService;
    }

    public function index(): JsonResponse
    {
        return $this->CoDService->getDataCoD()->toJson();
    }

    public function show($id): JsonResponse
    {
        return $this->CoDService->getCoDById($id)->toJson();
    }

    public function store(): JsonResponse
    {
        return $this->CoDService->createCoD()->toJson();
    }

    public function update($id): JsonResponse
    {
        return $this->CoDService->updateCoD($id)->toJson();
    }

    public function destroy($id): JsonResponse
    {
        return $this->CoDService->deleteCoDById($id)->toJson();
    }
}
