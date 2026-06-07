<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SocialLink extends Model
{
    protected $guarded = [];

    protected $casts = [
        'sort_order' => 'integer',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function linkable()
    {return $this->morphTo();}
}
