<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Models\TempJobIntern;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TempJobInternController extends Controller
{
    public function index(): JsonResponse
    {
        $search = request('q');

        switch (Auth::user()->role) {
            case UserRoles::ADMIN->value:
            case UserRoles::STAFF->value:
                $temp_job_interns = TempJobIntern::with(['user:id,name', 'job_intern:id'])
                    ->when(
                        $search,
                        fn($q) =>
                        $q->where('created', 'like', "%$search%")
                            ->orWhere('task', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->orWhere('deadline', 'like', "%$search%")
                            ->orWhere('status', 'like', "%$search%")
                            ->orWhere('manage_by', 'like', "%$search%")
                            ->orWhere('expired_at', 'like', "%$search%")
                            ->orWhereRelation('user', 'name', 'like', "%$search%")
                    )
                    ->orderByRaw("CASE WHEN status = 'Done' THEN 1 ELSE 0 END")
                    ->latest('created_at')
                    ->get();
                break;
            case UserRoles::INTERN->value:
                $temp_job_interns = TempJobIntern::with(['user:id,name', 'job_intern:id'])
                    ->when(
                        $search,
                        fn($q) =>
                        $q->where('created', 'like', "%$search%")
                            ->orWhere('task', 'like', "%$search%")
                            ->orWhere('description', 'like', "%$search%")
                            ->orWhere('deadline', 'like', "%$search%")
                            ->orWhere('status', 'like', "%$search%")
                            ->orWhere('manage_by', 'like', "%$search%")
                            ->orWhere('expired_at', 'like', "%$search%")
                            ->orWhereRelation('user', 'name', 'like', "%$search%")
                    )->where('user_id', Auth::id())
                    ->orderByRaw("CASE WHEN status = 'Done' THEN 1 ELSE 0 END")
                    ->latest('created_at')
                    ->get(['id', 'job_intern_id', 'user_id', 'created', 'task', 'description', 'deadline', 'status', 'manage_by', 'created_at']);
                break;
            default:
                throw new \Exception("Login Terlebih Dahulu.");
        }

        return response()->json([
            'status' => 'OK',
            'data' => $temp_job_interns,
        ]);
    }
}
