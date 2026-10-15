<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'filename', 'rarity_id'])]
class Card extends Model
{
    public function rarity(): BelongsTo
    {
        return $this->belongsTo(Rarity::class);
    }
}
