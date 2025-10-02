<?php

namespace App\Services\JobIntern;

use App\Enums\CheckJobStatus;
use App\Enums\UserRoles;
use App\Models\TempJobIntern;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\JobIntern\JobInternRepository;
use App\Repositories\User\UserRepository;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobInternServiceImplement extends ServiceApi implements JobInternService
{
    private string $title_job = "Data";
    private string $create_message_job = "berhasil dibuat";
    private string $update_message_job = "berhasil diubah";
    private string $delete_message_job = "berhasil dihapus";
    protected JobInternRepository $mainRepository;
    protected UserRepository $userRepository;
    private Request $request;

    public function __construct(JobInternRepository $mainRepository, Request $request, UserRepository $userRepository)
    {
        $this->mainRepository = $mainRepository;
        $this->userRepository = $userRepository;
        $this->request = $request;
    }

    public function getDataInternJob()
    {
        try {
            $data = $this->mainRepository->getDataInternJob();
            return $this->setCode(200)
                ->setMessage("OK")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getDataJobInternById($id)
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

    public function createInternJob()
    {
        try {
            $this->request->validate([
                'task' => ['required'],
                'description' => ['required'],
                'deadline' => ['nullable'],
            ]);

            $status = $this->request->enum('status', CheckJobStatus::class);

            switch (Auth::user()->role) {
                case UserRoles::ADMIN->value:
                    $data = $this->mainRepository->create([
                        'user_id' => $this->request->user_id,
                        'created' => today('Asia/Kuala_Lumpur')->isoFormat('dddd, DD MMMM Y'),
                        'task' => $this->request->task,
                        'description' => $this->request->description,
                        'deadline' => $this->request->deadline ?? CarbonImmutable::createFromDate(0001, 1, 1, 'Asia/Kuala_Lumpur'),
                        'status' => $status ?? CheckJobStatus::PENDING->value,
                        'manage_by' => Auth::user()->name,
                    ]);
                    TempJobIntern::create([
                        'job_intern_id' => $data->id,
                        'user_id' => $data->user_id,
                        'created' => $data->created,
                        'task' => $data->task,
                        'description' => $data->description,
                        'deadline' => $data->deadline,
                        'status' => $data->status,
                        'manage_by' => $data->manage_by,
                        'expired_at' => now('Asia/Kuala_Lumpur')->addWeek(),
                    ]);
                    break;
                case UserRoles::STAFF->value:
                    $data = $this->mainRepository->create([
                        'user_id' => $this->request->user_id,
                        'created' => today('Asia/Kuala_Lumpur')->isoFormat('dddd, DD MMMM Y'),
                        'task' => $this->request->task,
                        'description' => $this->request->description,
                        'deadline' => $this->request->deadline ?? CarbonImmutable::createFromDate(0001, 1, 1, 'Asia/Kuala_Lumpur'),
                        'status' => CheckJobStatus::PENDING->value,
                        'manage_by' => Auth::user()->name,
                    ]);
                    TempJobIntern::create([
                        'job_intern_id' => $data->id,
                        'user_id' => $data->user_id,
                        'created' => $data->created,
                        'task' => $data->task,
                        'description' => $data->description,
                        'deadline' => $data->deadline,
                        'status' => $data->status,
                        'manage_by' => $data->manage_by,
                        'expired_at' => now('Asia/Kuala_Lumpur')->addWeek(),
                    ]);
                    break;

                case UserRoles::INTERN->value:
                    $this->request->validate([
                        'manage_by' => ['required', 'string'],
                        'deadline' => ['required', 'date'],
                    ]);

                    if ($this->request->manage_by === $this->userRepository->checkIfInternBypassTheManageBy($this->request->manage_by)) {
                        throw new \Exception("Intern tidak boleh menentukan kerjaan nya dari intern yang lain! Hanya dari admin / staff saja!");
                    }

                    $data = $this->mainRepository->create([
                        'user_id' => Auth::id(),
                        'created' => today('Asia/Kuala_Lumpur')->isoFormat('dddd, DD MMMM Y'),
                        'task' => $this->request->task,
                        'description' => $this->request->description,
                        'deadline' => $this->request->deadline,
                        'status' => CheckJobStatus::PENDING->value,
                        'manage_by' => $this->request->manage_by,
                    ]);

                    TempJobIntern::create([
                        'job_intern_id' => $data->id,
                        'user_id' => $data->user_id,
                        'created' => $data->created,
                        'task' => $data->task,
                        'description' => $data->description,
                        'deadline' => $data->deadline,
                        'status' => $data->status,
                        'manage_by' => $data->manage_by,
                        'expired_at' => now('Asia/Kuala_Lumpur')->addWeek(),
                    ]);
                    break;
                default:
                    throw new \Exception("Tidak bisa melakukan input data, login terlebih dahulu.");
            }

            return $this->setCode(200)
                ->setMessage("$this->title_job $this->create_message_job & ditandai di temp_job_interns!")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function updateInternJob($id)
    {
        try {
            $this->request->validate([
                'task' => ['sometimes', 'required'],
                'description' => ['sometimes', 'required'],
                'deadline' => ['sometimes', 'required'],
                'status' => ['sometimes', 'required'],
            ]);
            $updateData = $this->request->only(['task', 'description', 'deadline', 'status', 'user_id']);

            if ($this->request->has('status')) {
                $updateData['status'] = $this->request->enum('status', CheckJobStatus::class);
            }

            $data = $this->mainRepository->update($id, $updateData);
            if ($id && !empty($updateData)) {
                $jobIntern = $this->mainRepository->findOrFail($id);
                $tempJobInternId = TempJobIntern::where('job_intern_id', $id)->first(['id', 'expired_at']);

                TempJobIntern::where('job_intern_id', $id)->delete();

                TempJobIntern::create([
                    'job_intern_id' => $id,
                    'user_id' => $jobIntern->user_id,
                    'created' => $jobIntern->created,
                    'task' => $jobIntern->task,
                    'description' => $jobIntern->description,
                    'deadline' => $jobIntern->deadline,
                    'status' => $jobIntern->status,
                    'manage_by' => $jobIntern->manage_by,
                    'expired_at' => $tempJobInternId->expired_at,
                ]);
            }

            return $this->setCode(200)
                ->setMessage("$this->title_job $this->update_message_job & ditandai di temp_job_interns!")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function deleteJobInternById($id)
    {
        try {
            $data = $this->mainRepository->delete($id);
            return $this->setCode(200)
                ->setMessage("$this->title_job $this->delete_message_job!")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
