<?php

namespace App\Repositories\User;

use App\Enums\UserRoles;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRepositoryImplement extends Eloquent implements UserRepository
{
    /**
     * Model class to be used in this repository for the common methods inside Eloquent.
     * Don't remove or change $this->model variable name.
     * @property Model|mixed $model;
     */
    protected User $model;

    protected $search;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->search = request('search');
    }

    public function getDataUser()
    {
        switch (Auth::user()->role) {
            case UserRoles::ADMIN->value:
                return $this->model->latest('created_at')->when(
                    $this->search,
                    fn($q) =>
                    $q->where('name', 'like', "%$this->search%")
                        ->orWhere('email', 'like', "%$this->search%")
                        ->orWhere('date', 'like', "%$this->search%")
                        ->orWhere('role', 'like', "%$this->search%")
                        ->orWhere('bio', 'like', "%$this->search%")
                        ->orWhere('institution', 'like', "%$this->search%")
                        ->orWhere('due_date', 'like', "%$this->search%")
                )->get();
            case UserRoles::STAFF->value:
                return $this->model->latest('created_at')->when(
                    $this->search,
                    fn($q) =>
                    $q->where('name', 'like', "%$this->search%")
                        ->orWhere('email', 'like', "%$this->search%")
                        ->orWhere('date', 'like', "%$this->search%")
                        ->orWhere('role', 'like', "%$this->search%")
                        ->orWhere('bio', 'like', "%$this->search%")
                        ->orWhere('institution', 'like', "%$this->search%")
                        ->orWhere('due_date', 'like', "%$this->search%")
                )->where('role', '=', 'intern')->get();
            case UserRoles::INTERN->value:
                return $this->model->latest('created_at')->when(
                    $this->search,
                    fn($q) =>
                    $q->where('name', 'like', "%$this->search%")
                        ->orWhere('email', 'like', "%$this->search%")
                        ->orWhere('date', 'like', "%$this->search%")
                        ->orWhere('role', 'like', "%$this->search%")
                        ->orWhere('bio', 'like', "%$this->search%")
                        ->orWhere('institution', 'like', "%$this->search%")
                        ->orWhere('due_date', 'like', "%$this->search%")
                )->where('role', '=', 'intern')->get();
            default:
                throw new \Exception("Login Terlebih Dahulu.");
        }
    }
}
