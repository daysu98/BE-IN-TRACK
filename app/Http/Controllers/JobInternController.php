<?php

namespace App\Http\Controllers;

use App\Services\JobIntern\JobInternService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobInternController extends Controller
{
    private $jobInternService;

    public function __construct(JobInternService $jobInternService)
    {
        $this->jobInternService = $jobInternService;
    }

    public function index(): JsonResponse
    {
        return $this->jobInternService->getDataInternJob()->toJson();
    }

    public function show($id): JsonResponse
    {
        return $this->jobInternService->getDataJobInternById($id)->toJson();
    }

    public function store(): JsonResponse
    {
        return $this->jobInternService->createInternJob()->toJson();
    }

    public function update($id): JsonResponse
    {
        return $this->jobInternService->updateInternJob($id)->toJson();
    }

    public function destroy($id): JsonResponse
    {
        return $this->jobInternService->deleteJobInternById($id)->toJson();
    }
}
