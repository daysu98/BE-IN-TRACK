<?php

namespace App\Repositories\JobIntern;

use App\Enums\UserRoles;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\JobIntern;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobInternRepositoryImplement extends Eloquent implements JobInternRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected JobIntern $model;

    private $search;

    public function __construct(JobIntern $model)
    {
        $this->model = $model;
        $this->search = request('search');
    }

    public function getDataInternJob()
    {
        switch (Auth::user()->role) {
            case UserRoles::ADMIN->value:
                return $this->model->with(['user'])->when(
                    $this->search,
                    fn($q) =>
                    $q->where('task', 'like', "%$this->search%")
                        ->orWhere('created', 'like', "%$this->search%")
                        ->orWhere('description', 'like', "%$this->search%")
                        ->orWhere('status', 'like', "%$this->search%")
                        ->orWhere('manage_by', 'like', "%$this->search%")
                        ->orWhere('deadline_iso', 'like', "%$this->search%")
                        ->orWhereRelation('user', 'name', 'like', "%$this->search%")
                )->orderByRaw("FIELD(status, 'Pending', 'Done')")->orderByRaw("CASE WHEN status = 'Pending' THEN deadline END ASC")->orderByRaw("CASE WHEN status = 'Done' THEN deadline END DESC")->get();
            case UserRoles::STAFF->value:
                return $this->model->with(['user'])->when(
                    $this->search,
                    fn($q) =>
                    $q->where('task', 'like', "%$this->search%")
                        ->orWhere('created', 'like', "%$this->search%")
                        ->orWhere('description', 'like', "%$this->search%")
                        ->orWhere('status', 'like', "%$this->search%")
                        ->orWhere('manage_by', 'like', "%$this->search%")
                        ->orWhere('deadline_iso', 'like', "%$this->search%")
                        ->orWhereRelation('user', 'name', 'like', "%$this->search%")
                )->orderByRaw("FIELD(status, 'Pending', 'Done')")->orderByRaw("CASE WHEN status = 'Pending' THEN deadline END ASC")->orderByRaw("CASE WHEN status = 'Done' THEN deadline END DESC")->where('manage_by', Auth::user()->name)->get();
            case UserRoles::INTERN->value:
                return $this->model->with(['user'])->when(
                    $this->search,
                    fn($q) =>
                    $q->where('task', 'like', "%$this->search%")
                        ->orWhere('created', 'like', "%$this->search%")
                        ->orWhere('description', 'like', "%$this->search%")
                        ->orWhere('status', 'like', "%$this->search%")
                        ->orWhere('manage_by', 'like', "%$this->search%")
                        ->orWhere('deadline_iso', 'like', "%$this->search%")
                        ->orWhereRelation('user', 'name', 'like', "%$this->search%")
                )->orderByRaw("FIELD(status, 'Pending', 'Done')")->orderByRaw("CASE WHEN status = 'Pending' THEN deadline END ASC")->orderByRaw("CASE WHEN status = 'Done' THEN deadline END DESC")->where('user_id', Auth::id())->get();
            default;
        }
    }
}
