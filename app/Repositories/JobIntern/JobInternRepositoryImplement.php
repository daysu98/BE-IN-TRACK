<?php

namespace App\Repositories\JobIntern;

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
            case 'admin':
            case 'staff':
                return $this->model->with(['user'])->when(
                    $this->search,
                    fn($q) =>
                    $q->where('task', 'like', "%$this->search%")
                        ->orWhere('created', 'like', "%$this->search%")
                        ->orWhere('description', 'like', "%$this->search%")
                        ->orWhere('status', 'like', "%$this->search%")
                        ->orWhere('manage_by', 'like', "%$this->search%")
                        ->orWhereRelation('user', 'name', 'like', "%$this->search%")
                )->orderByRaw("CASE WHEN status = 'Done' THEN 1 ELSE 0 END")->oldest('created_at')->get();
            case 'intern':
                return $this->model->with(['user'])->when(
                    $this->search,
                    fn($q) =>
                    $q->where('task', 'like', "%$this->search%")
                        ->orWhere('created', 'like', "%$this->search%")
                        ->orWhere('description', 'like', "%$this->search%")
                        ->orWhere('status', 'like', "%$this->search%")
                        ->orWhere('manage_by', 'like', "%$this->search%")
                        ->orWhereRelation('user', 'name', 'like', "%$this->search%")
                )->orderByRaw("CASE WHEN status = 'Done' THEN 1 ELSE 0 END")->oldest('created_at')->where('user_id', Auth::id())->get();
            default;
        }
    }
}
