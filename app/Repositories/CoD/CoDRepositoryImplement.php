<?php

namespace App\Repositories\CoD;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\CallOfDuty;
use Illuminate\Database\Eloquent\Model;

class CoDRepositoryImplement extends Eloquent implements CoDRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected CallOfDuty $model;

    protected $search;

    public function __construct(CallOfDuty $model)
    {
        $this->model = $model;
        $this->search = request('search');
    }

    public function getDataCoD()
    {
        return $this->model->latest('created_at')->with(['user'])->when(
            $this->search,
            fn($q) =>
            $q->where('days', 'like', "%$this->search%")
                ->orWhereRelation('user', 'name', 'like', "%$this->search%")
        )->get();
    }
}
