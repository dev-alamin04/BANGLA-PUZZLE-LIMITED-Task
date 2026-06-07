<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = [];
    protected $hidden  = ['created_at', 'updated_at'];
    protected $casts   = [
        'id'         => 'integer',
        'user_id'    => 'integer',
        'read_at'    => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'meta'       => 'array',
    ];

    public function user()
    {return $this->belongsTo(User::class);}

    public function notifiable()
    {return $this->morphTo();}

    public function scopeUnread($q)
    {return $q->whereNull('read_at');}
}
