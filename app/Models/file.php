<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    protected $table = 'files'; // Optional, only if the table name differs from the model name

    protected $fillable = ['user_id', 'filepath', 'filename', 'filetype', 'filesize'];

    // Define the relationship to the User model if applicable
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



}

#file has : id/ user.id/ filepath/ filename/ filetype/ filesize
