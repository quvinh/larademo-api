<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'view',
        'status',
        'created_by',
        'image'
    ];

    public function userName()
    {
        return $this->hasOne(User::class, 'created_by', 'id');
    }
}
