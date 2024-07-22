<?php

namespace App\Domain\Meeting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meetings extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function participants(): HasMany
    {
        return $this->hasMany(Participants::class);
    }
}
