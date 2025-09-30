<?php

namespace App\Services\CoD;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\CoD\CoDRepository;
use Illuminate\Http\Request;

class CoDServiceImplement extends ServiceApi implements CoDService
{
    /**
     * set title message api for CRUD
     * @param string $title
     */
    private string $title_cod = "Data";
    private string $create_message_cod = "berhasil dibuat";
    private string $update_message_cod = "berhasil diubah";
    private string $delete_message_cod = "berhasil dihapus";

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected CoDRepository $mainRepository;

    protected Request $request;

    public function __construct(CoDRepository $mainRepository, Request $request)
    {
        $this->mainRepository = $mainRepository;
        $this->request = $request;
    }

    public function getDataCoD()
    {
        try {
            $data = $this->mainRepository->getDataCoD();

            return $this->setCode(200)
                ->setMessage("OK")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function getCoDById($id)
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

    public function createCoD()
    {
        try {
            $this->request->validate([
                'user_id' => ['required'],
                'days' => ['required'],
            ]);

            $data = $this->mainRepository->create([
                'user_id' => $this->request->user_id,
                'days' => $this->request->days ?? today('Asia/Kuala_Lumpur')->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l'),
            ]);

            return $this->setCode(200)
                ->setMessage("$this->title_cod $this->create_message_cod!")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function updateCoD($id)
    {
        try {
            $validated = $this->request->validate([
                'user_id' => ['required'],
                'days' => ['required'],
            ]);

            $data = $this->mainRepository->update($id, $validated);

            return $this->setCode(200)
                ->setMessage("$this->title_cod $this->update_message_cod!")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function deleteCoDById($id)
    {
        try {
            $data = $this->mainRepository->delete($id);

            return $this->setCode(200)
                ->setMessage("$this->title_cod $this->delete_message_cod!")
                ->setData($data);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
