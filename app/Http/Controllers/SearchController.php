<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $q;

    public function __construct()
    {
        $this->q = request('search');
    }

    public function search(): JsonResponse
    {
        $search = User::when(
            $this->q,
            fn($w) =>
            $w->where('name', 'like', "%$this->q%")
                ->orWhere('email', 'like', "%$this->q%")
                ->orWhere('date', 'like', "%$this->q%")
                ->orWhere('role', 'like', "%$this->q%")
                ->orWhereRelation('intern_attends', 'status', 'like', "%$this->q%")
                ->orWhereRelation('intern_attends', 'tanggal', 'like', "%$this->q%")
                ->orWhereRelation('intern_attends', 'jam_masuk', 'like', "%$this->q%")
                ->orWhereRelation('intern_attends', 'jam_keluar', 'like', "%$this->q%")
                ->orWhereRelation('job_interns', 'created', 'like', "%$this->q%")
                ->orWhereRelation('job_interns', 'task', 'like', "%$this->q%")
                ->orWhereRelation('job_interns', 'description', 'like', "%$this->q%")
                ->orWhereRelation('job_interns', 'deadline', 'like', "%$this->q%")
                ->orWhereRelation('job_interns', 'status', 'like', "%$this->q%")
                ->orWhereRelation('call_of_duties', 'days', 'like', "%$this->q%")
                ->orWhereRelation('temp_intern_attends', 'status', 'like', "%$this->q%")
                ->orWhereRelation('temp_intern_attends', 'tanggal', 'like', "%$this->q%")
                ->orWhereRelation('temp_intern_attends', 'jam_masuk', 'like', "%$this->q%")
                ->orWhereRelation('temp_intern_attends', 'jam_keluar', 'like', "%$this->q%")
                ->orWhereRelation('temp_intern_attends', 'expired_at', 'like', "%$this->q%")
                ->orWhereRelation('temp_job_interns', 'created', 'like', "%$this->q%")
                ->orWhereRelation('temp_job_interns', 'task', 'like', "%$this->q%")
                ->orWhereRelation('temp_job_interns', 'description', 'like', "%$this->q%")
                ->orWhereRelation('temp_job_interns', 'deadline', 'like', "%$this->q%")
                ->orWhereRelation('temp_job_interns', 'status', 'like', "%$this->q%")
                ->orWhereRelation('temp_job_interns', 'expired_at', 'like', "%$this->q%")
        )->get();

        return response()->json([
            'search' => $search,
        ]);
    }
}
