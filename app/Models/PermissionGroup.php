<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'permission_id',
        'created_by',
        'updated_by'
    ];

    public function permission()
    {
        return $this->hasOne(Permission::class, 'permission_id', 'id');
    }
}
