<?php

namespace App\Repositories;

use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleRepository extends BaseRepository
{
    public function model()
    {
        return Role::class;
    }

    public function getFieldsSearchable()
    {
        return $this->model->getFields();
    }

    public function createRole($data)
    {
        try {
            $isCreated = $this->model->create($data);
            return $isCreated;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateRole($id, $data)
    {
        try {
            return $this->update($id, $data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function deleteRole($id)
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

    public function getRoleBy($condition = [])
    {
        $model = $this->model();
        if ($condition) {
            $model = $model::where($condition);
        }
        return $model->get();
    }

    public function getDeleteOfRole($condition = [])
    {
        $model = $this->model()::onlyTrashed();
        if ($condition) {
            $model = $model->where($condition);
        }
        return $model->get();
    }

    public function restoreRoleBy($id)
    {
        return $this->model()::onlyTrashed()->where('id', $id)->restore();
    }

    public function forceDeleteRoleBy($id)
    {
        return $this->model()::onlyTrashed()->where('id', $id)->forceDelete();
    }
}
