<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UploadedFile extends Model
{
    protected $table = 'files'; // Optional, only if the table name differs from the model name

    protected $fillable = ['userid', 'filepath', 'filename', 'filetype', 'filesize'];

    // Define the relationship to the User model if applicable
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



}

#file has : id/user.id/ filepath/ filename/ filetype/ filesize
