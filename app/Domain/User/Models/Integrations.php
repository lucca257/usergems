<?php

namespace App\Domain\User\Models;

use App\Domain\Company\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Integrations extends Authenticatable
{
    use HasFactory;

    public $guarded = [];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
