<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponentVariant extends Model
{
    protected $fillable = ['component_id', 'name', 'classes', 'preview_props', 'is_default'];

    protected $casts = [
        'preview_props' => 'array',
        'is_default' => 'boolean',
    ];

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }
}
