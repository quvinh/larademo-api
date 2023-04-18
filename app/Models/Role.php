<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'created_by'
    ];

    public function userName()
    {
        return $this->hasOne(User::class, 'created_by', 'id');
    }

    public function permissionGroup()
    {
        return $this->hasMany(PermissionGroup::class, 'role_id', 'id');
    }

    public function getNamePermission()
    {
        $permissions = array_map(function ($item) {
            $permission = Permission::find($item['permission_id']);
            if ($permission) {
                return $permission->name;
            }
        }, $this->permissionGroup()->toArray());
        return implode(', ', $permissions);
    }

    public function getIdOfPermission()
    {
        $permissions = array_map(function ($item) {
            $permission = Permission::find($item['permission_id']);
            if ($permission) {
                return $permission->id;
            }
        }, $this->permissionGroup()->toArray());
        return $permissions;
    }
}
