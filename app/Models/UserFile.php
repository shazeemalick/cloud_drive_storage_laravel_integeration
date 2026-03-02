<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    /** @use HasFactory<\Database\Factories\UserFileFactory> */
    use HasFactory;

    protected $fillable = [
        'email',
        'folder_id',
        'file_id',
        'file_name',
    ];

    public function folder()
    {
        return $this->belongsTo(UserFolder::class, 'folder_id');
    }
}
