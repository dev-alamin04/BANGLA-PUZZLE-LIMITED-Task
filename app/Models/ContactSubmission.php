<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSubmission extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'id'         => 'integer',
        'is_read'    => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];
}
