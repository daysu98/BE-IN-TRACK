<?php

namespace App\Services\InternAttend;

use App\Enums\CheckAttendStatus;
use App\Models\InternAttend;
use App\Models\TempInternAttend;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\InternAttend\InternAttendRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class InternAttendServiceImplement extends ServiceApi implements InternAttendService
{
    private string $title_intern = "Absen";
    private string $create_message_intern = "berhasil dibuat";
    private string $update_message_intern = "berhasil diubah";
    private string $delete_message_intern = "berhasil dihapus";
    protected InternAttendRepository $mainRepository;
    private Request $request;

    public function __construct(InternAttendRepository $mainRepository, Request $request)
    {
        $this->mainRepository = $mainRepository;
        $this->request = $request;
    }

    public function getDataAttend()
    {
        try {
            $data = $this->mainRepository->getDataAttend();
            return $this->setCode(200)->setMessage("OK")->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getInternAttendById($id)
    {
        try {
            $data = $this->mainRepository->findOrFail($id);
            return $this->setCode(200)->setMessage("OK")->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function createAttend()
    {
        try {
            $this->request->validate(['status' => ['required', new Enum(CheckAttendStatus::class)],]);
            $status = $this->request->enum('status', CheckAttendStatus::class);
            $userId = Auth::user()->role === 'intern' ? Auth::id() : $this->request->user_id;
            $existingAttendance = InternAttend::where('user_id', $userId)
                ->where('tanggal', today('Asia/Kuala_Lumpur')->toDateString())->first();
            if ($existingAttendance) {
                return $this->setCode(409)->setMessage("Attendance for today already exists.")->setData(null);
            }

            switch (Auth::user()->role) {
                case 'admin':
                case 'staff':
                    $data = $this->mainRepository->create(
                        [
                            'user_id' => $this->request->user_id,
                            'status' => $status,
                            'tanggal' => $this->request->tanggal,
                            'jam_masuk' => $this->request->jam_masuk ?? null,
                            'jam_keluar' => $this->request->jam_keluar ?? null,

                        ]
                    );
                    break;
                case 'intern':
                    $isSickOrPermitted = in_array($status, [CheckAttendStatus::SAKIT, CheckAttendStatus::IJIN, CheckAttendStatus::ALPA]);
                    $data = $this->mainRepository->create(
                        [
                            'user_id' => Auth::id(),
                            'status' => $status,
                            'tanggal' => today('Asia/Kuala_Lumpur')->toDateString(),
                            'jam_masuk' => $isSickOrPermitted ? null : now('Asia/Kuala_Lumpur')->toTimeString(),
                            'jam_keluar' => null,

                        ]
                    );
                    break;
                default:
                    return $this->setCode(403)->setMessage("Unauthorized Role")->setData(null);
            }

            TempInternAttend::create(['intern_attend_id' => $data->id, 'user_id' => $data->user_id, 'status' => $data->status, 'tanggal' => $data->tanggal, 'jam_masuk' => $data->jam_masuk, 'jam_keluar' => $data->jam_keluar, 'expired_at' => now('Asia/Kuala_Lumpur')->addWeek(),]);
            return $this->setCode(200)->setMessage("$this->title_intern $this->create_message_intern")->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function checkoutAttend()
    {
        try {
            $userId = Auth::id();
            $attendance = InternAttend::where('user_id', $userId)
                ->where('tanggal', today('Asia/Kuala_Lumpur')->toDateString())
                ->firstOrFail();
            if ($attendance->jam_keluar && $attendance->jam_keluar !== null) { // [MODIFIKASI]: Menambahkan pengecekan null
                return $this->setCode(409)->setMessage("Already checked out for today.")->setData($attendance);
            }

            $attendance->update(['jam_keluar' => now('Asia/Kuala_Lumpur')->toTimeString()]);
            TempInternAttend::updateOrCreate(
                ['intern_attend_id' => $attendance->id],
                [
                    'user_id' => $userId,
                    'status' => $attendance->status,
                    'tanggal' =>
                        $attendance->tanggal,
                    'jam_masuk' => $attendance->jam_masuk,
                    'jam_keluar' => $attendance->jam_keluar,
                    'expired_at' => now('Asia/Kuala_Lumpur')->addWeek()
                ]
            );
            return $this->setCode(200)
                ->setMessage("Checkout successful!")
                ->setData($attendance);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function updateAttend($id)
    {
        try {
            $this->request->validate(['status' => ['sometimes', 'required', new Enum(CheckAttendStatus::class)], 'tanggal' => ['sometimes', 'required'],]);
            $updateData = $this->request->only(['user_id', 'tanggal', 'jam_masuk', 'jam_keluar']);

            if ($this->request->has('status')) {
                $updateData['status'] = $this->request->enum('status', CheckAttendStatus::class);
            }

            $data = $this->mainRepository->update($id, $updateData);
            TempInternAttend::updateOrCreate(
                ['intern_attend_id' => $data->id],
                ['user_id' => $data->user_id, 'status' => $data->status, 'tanggal' => $data->tanggal, 'jam_masuk' => $data->jam_masuk, 'jam_keluar' => $data->jam_keluar, 'expired_at' => now('Asia/Kuala_Lumpur')->addWeek()]
            );
            return $this->setCode(200)->setMessage("$this->title_intern $this->update_message_intern")->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function deleteInternAttendById($id)
    {
        try {
            $data = $this->mainRepository->delete($id);
            return $this->setCode(200)->setMessage("$this->title_intern $this->delete_message_intern!")->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
