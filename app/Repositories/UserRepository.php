<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    public function getFieldsSearchable()
    {
        return $this->model->getFields();
    }

    public function createUser($data)
    {
        try {
            $isCreated = $this->model->create($data);
            return $isCreated;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateUser($id, $data)
    {
        try {
            return $this->update($id, $data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function deleteUser($id)
    {
        DB::beginTransaction();
        try {
            $this->delete($id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return false;
        }
    }

    public function getUserBy($condition = [])
    {
        $model = $this->model();
        if ($condition) {
            $model = $model::where($condition);
        }
        return $model->get();
    }

    public function getDeleteOfUser($condition = [])
    {
        $model = $this->model()::onlyTrashed();
        if ($condition) {
            $model = $model->where($condition);
        }
        return $model->get();
    }

    public function restoreUserBy($id)
    {
        return $this->model()::onlyTrashed()->where('id', $id)->restore();
    }

    public function forceDeleteUserBy($id)
    {
        return $this->model()::onlyTrashed()->where('id', $id)->forceDelete();
    }
}
