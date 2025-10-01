<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Models\TempInternAttend;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TempInternAttendController extends Controller
{
    public function index(): JsonResponse
    {
        $search = request('q');

        switch (Auth::user()->role) {
            case UserRoles::ADMIN->value:
            case UserRoles::STAFF->value:
                $temp_intern_attends = TempInternAttend::latest('created_at')
                    ->with(['user:id,name', 'intern_attend:id'])
                    ->when(
                        $search,
                        fn($q) =>
                        $q->where('status', 'like', "%$search%")
                            ->orWhere('tanggal', 'like', "%$search%")
                            ->orWhere('jam_masuk', 'like', "%$search%")
                            ->orWhere('jam_keluar', 'like', "%$search%")
                            ->orWhere('expired_at', 'like', "%$search%")
                            ->orWhereRelation('user', 'name', 'like', "%$search%")
                    )->get();
                break;
            case UserRoles::INTERN->value:
                $temp_intern_attends = TempInternAttend::latest('created_at')
                    ->with(['user:id,name', 'intern_attend:id'])
                    ->when(
                        $search,
                        fn($q) =>
                        $q->where('status', 'like', "%$search%")
                            ->orWhere('tanggal', 'like', "%$search%")
                            ->orWhere('jam_masuk', 'like', "%$search%")
                            ->orWhere('jam_keluar', 'like', "%$search%")
                            ->orWhere('expired_at', 'like', "%$search%")
                            ->orWhereRelation('user', 'name', 'like', "%$search%")
                    )->where('user_id', Auth::id())->get(['id', 'user_id', 'status', 'tanggal', 'jam_masuk', 'jam_keluar', 'created_at']);
                break;
            default:
                throw new \Exception("Login Terlebih Dahulu.");
        }

        return response()->json([
            'status' => 'OK',
            'data' => $temp_intern_attends,
        ]);
    }
}
