<?php

namespace App\Repositories\InternAttend;

use App\Enums\UserRoles;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\InternAttend;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InternAttendRepositoryImplement extends Eloquent implements InternAttendRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected InternAttend $model;

    private $search;

    public function __construct(InternAttend $model)
    {
        $this->model = $model;
        $this->search = request('search');
    }

    public function getDataAttend()
    {
        switch (Auth::user()->role) {
            case UserRoles::ADMIN->value:
                return $this->model->latest('created_at')->with(['user'])->when(
                    $this->search,
                    fn($q) =>
                    $q->where('status', 'like', "%$this->search%")
                        ->orWhere('tanggal', 'like', "%$this->search%")
                        ->orWhere('jam_masuk', 'like', "%$this->search%")
                        ->orWhere('jam_keluar', 'like', "%$this->search")
                        ->orWhere('tanggal_iso', 'like', "%$this->search")
                        ->orWhereRelation('user', 'name', 'like', "%$this->search%")
                )->get();
            case UserRoles::STAFF->value:
                return $this->model->latest('created_at')->with(['user'])->whereHas(
                    'user',
                    fn($q) =>
                    $q->where('role', '=', 'intern')
                )->when(
                        $this->search,
                        fn($q) =>
                        $q->where('status', 'like', "%$this->search%")
                            ->orWhere('tanggal', 'like', "%$this->search%")
                            ->orWhere('jam_masuk', 'like', "%$this->search%")
                            ->orWhere('jam_keluar', 'like', "%$this->search")
                            ->orWhere('tanggal_iso', 'like', "%$this->search")
                            ->orWhereRelation('user', 'name', 'like', "%$this->search%")
                    )->get();
            case UserRoles::INTERN->value:
                return $this->model->latest('created_at')->with(['user'])->when(
                    $this->search,
                    fn($q) =>
                    $q->where('status', 'like', "%$this->search%")
                        ->orWhere('tanggal', 'like', "%$this->search%")
                        ->orWhere('jam_masuk', 'like', "%$this->search%")
                        ->orWhere('jam_keluar', 'like', "%$this->search")
                        ->orWhere('tanggal_iso', 'like', "%$this->search")
                        ->orWhereRelation('user', 'name', 'like', "%$this->search%")
                )->where('user_id', Auth::id())->get();
            default:
                throw new \Exception("Login Terlebih Dahulu.");
        }

    }

    public function checkIfAttendIsExist($userId): bool
    {
        return $this->model->where('user_id', $userId)->where('tanggal', today('Asia/Kuala_Lumpur')->toDateString())->exists();
    }

    public function checkIfInternHasBeenCheckout(): InternAttend
    {
        return $this->model->where('user_id', Auth::id())
            ->where('tanggal', today('Asia/Kuala_Lumpur')->toDateString())
            ->firstOrFail();
    }
}
