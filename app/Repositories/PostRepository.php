<?php

namespace App\Repositories;

use App\Models\Post;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostRepository extends BaseRepository
{
    public function model()
    {
        return Post::class;
    }

    public function getFieldsSearchable()
    {
        return $this->model->getFields();
    }

    public function createPost($data)
    {
        try {
            $isCreated = $this->model->create($data);
            return $isCreated;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updatePost($id, $data)
    {
        try {
            return $this->update($id, $data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function deletePost($id)
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

    public function getPostBy($condition = [])
    {
        $model = $this->model();
        if ($condition) {
            $model = $model::where($condition);
        }
        return $model->get();
    }

    public function getDeleteOfPost($condition = [])
    {
        $model = $this->model()::onlyTrashed();
        if ($condition) {
            $model = $model->where($condition);
        }
        return $model->get();
    }

    public function restorePostBy($id)
    {
        return $this->model()::onlyTrashed()->where('id', $id)->restore();
    }

    public function forceDeletePostBy($id)
    {
        return $this->model()::onlyTrashed()->where('id', $id)->forceDelete();
    }
}
