<?php

namespace App\Http\Controllers;

use App\Models\PicketTask;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PicketTaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $tasks = PicketTask::query();
        if ($request->has('day')) {
            $tasks->where('day', $request->day);
        }
        return response()->json($tasks->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'task_description' => 'required|string|max:255',
        ]);

        $task = PicketTask::create($validated);

        return response()->json($task, 201);
    }

    public function show(PicketTask $picketTask): JsonResponse
    {
        return response()->json($picketTask);
    }

    public function update(Request $request, PicketTask $picketTask): JsonResponse
    {
        $validated = $request->validate([
            'task_description' => 'required|string|max:255',
        ]);

        $picketTask->update($validated);

        return response()->json($picketTask);
    }

    public function destroy(PicketTask $picketTask): JsonResponse
    {
        $picketTask->delete();

        return response()->json(null, 204);
    }
}
