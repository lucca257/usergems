<?php

namespace App\Domain\Meeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participants extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }
}
