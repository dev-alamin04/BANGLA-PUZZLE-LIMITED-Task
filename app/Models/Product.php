<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'description',
        'old_price',
        'new_price',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable')->where('collection', 'images')->orderBy('order');
    }

    public function thumbnail(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('collection', 'images')->orderBy('order');
    }
}
