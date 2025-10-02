<?php

namespace App\Services\User;

use App\Enums\UserRoles;
use Illuminate\Support\Str;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\User\UserRepository;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserServiceImplement extends ServiceApi implements UserService
{
    private string $title_user = "User";
    private string $create_message_user = "berhasil dibuat";
    private string $update_message_user = "berhasil diubah";
    private string $delete_message_user = "berhasil dihapus";

    protected UserRepository $mainRepository;
    private Request $request;
    private $file;

    public function __construct(UserRepository $mainRepository, Request $request)
    {
        $this->mainRepository = $mainRepository;
        $this->request = $request;
        $this->file = $request->file('photo');
    }

    public function getDataUser()
    {
        try {
            $data = $this->mainRepository->getDataUser();

            return $this->setCode(200)
                ->setMessage("OK")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getUserById($id)
    {
        try {
            $data = $this->mainRepository->findOrFail($id);

            return $this->setCode(200)
                ->setMessage("OK")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getStaffUser()
    {
        try {
            $data = $this->mainRepository->getStaffList();

            return $this->setCode(200)
                ->setMessage("OK")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function createUser()
    {
        try {
            $this->request->validate([
                'name' => ['required'],
                'email' => ['required', 'unique:users,email'],
                'password' => ['required', 'confirmed', 'min:6'],
                'role' => ['required'],
                'bio' => ['nullable', 'string'],
                'institution' => ['nullable', 'string'],
                'due_date' => ['nullable', 'date'],
                'photo' => ['nullable', 'mimes:png,jpg,webp', 'max:1024'],
            ]);

            if ($this->request->role === UserRoles::ADMIN->value) {
                if ($this->mainRepository->checkIfAdminExist()) {
                    throw new \Exception("Tidak boleh menambah admin lagi.");
                }
            }

            if ($this->file) {
                $fileName = Str::random(70) . '.' . $this->file->extension();

                $this->file->storeAs('img/avt', $fileName, 'public');
            }

            $data = $this->mainRepository->create([
                'name' => $this->request->name,
                'email' => $this->request->email,
                'date' => today('Asia/Kuala_Lumpur')->isoFormat('DD MMM YYYY'),
                'password' => $this->request->password,
                'role' => $this->request->role,
                'bio' => $this->request->bio ?? '-',
                'institution' => $this->request->institution ?? '-',
                'due_date' => $this->request->due_date ?? CarbonImmutable::createFromDate(0001, 1, 1, 'Asia/Kuala_Lumpur'),
                'photo' => $fileName ?? '-',
            ]);

            return $this->setCode(200)
                ->setMessage("$this->title_user $this->create_message_user!")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function updateUser($id)
    {
        try {
            $getUserId = $this->mainRepository->findOrFail($id);

            if ($getUserId->role === UserRoles::ADMIN->value) {
                if (Auth::id() !== $id) {
                    throw new \Exception("Dilarang edit admin selain admin sendiri!");
                }
            }

            $this->request->validate([
                'name' => ['sometimes', 'required'],
                'email' => ['sometimes', 'required', "unique:users,email,$id"],
                'password' => ['sometimes', 'nullable', 'confirmed', 'min:6'],
                'role' => ['sometimes', 'required'],
                'institution' => ['sometimes', 'nullable', 'string'],
                'due_date' => ['sometimes', 'nullable', 'date'],
                'photo' => ['sometimes', 'nullable', 'mimes:png,jpg,webp,gif', 'max:1024'],
            ]);

            $updateData = $this->request->only(['name', 'email', 'role', 'institution', 'due_date']);

            if ($this->request->filled('password')) {
                $updateData['password'] = $this->request->password;
            }

            if ($this->file) {
                if ($getUserId->photo && $getUserId->photo !== '-') {
                    Storage::disk('public')->delete("img/avt/$getUserId->photo");
                }
                $fileName = Str::random(70) . '.' . $this->file->extension();

                $this->file->storeAs('img/avt', $fileName, 'public');

                $updateData['photo'] = $fileName;
            }

            $data = $this->mainRepository->update($id, $updateData);

            return $this->setCode(200)
                ->setMessage("$this->title_user $this->update_message_user!")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function deleteUserById($id)
    {
        try {
            $getUserId = $this->mainRepository->findOrFail($id);

            if ($getUserId->role === UserRoles::ADMIN->value) {
                throw new \Exception("Dilarang menghapus user admin!");
            }

            if ($getUserId->photo and $getUserId->photo !== '-') {
                Storage::disk('public')->delete("img/avt/$getUserId->photo"); // true
            }
            // false

            $data = $this->mainRepository->delete($id);
            return $this->setCode(200)
                ->setMessage("$this->title_user $this->delete_message_user!")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
