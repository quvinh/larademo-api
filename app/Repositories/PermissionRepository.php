<?php

namespace App\Repositories;

use App\Models\Permission;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PermissionRepository extends BaseRepository
{
    public function model()
    {
        return Permission::class;
    }

    public function getFieldsSearchable()
    {
        return $this->model->getFields();
    }

    public function createPermission($data)
    {
        try {
            $isCreated = $this->model->create($data);
            return $isCreated;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updatePermission($id, $data)
    {
        try {
            return $this->update($id, $data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function deletePermission($id)
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

    public function getPermissionBy($condition = [])
    {
        $model = $this->model();
        if ($condition) {
            $model = $model::where($condition);
        }
        return $model->get();
    }

    public function getDeleteOfPermission($condition = [])
    {
        $model = $this->model()::onlyTrashed();
        if ($condition) {
            $model = $model->where($condition);
        }
        return $model->get();
    }

    public function restorePermissionBy($id)
    {
        return $this->model()::onlyTrashed()->where('id', $id)->restore();
    }

    public function forceDeletePermissionBy($id)
    {
        return $this->model()::onlyTrashed()->where('id', $id)->forceDelete();
    }
}
