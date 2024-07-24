<?php

namespace App\Domain\Meeting\Models;

use App\Domain\Meeting\Repository\MeetingRepository;
use App\Domain\User\Models\Integrations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Meeting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function integration(): HasOne
    {
        return $this->hasOne(Integrations::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participants::class);
    }

    public function newEloquentBuilder($query): MeetingRepository
    {
        return new MeetingRepository($query);
    }
}
