<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Resident extends \Illuminate\Foundation\Auth\User
{
    use HasApiTokens,HasFactory, HasUuids;

    protected $table = "residents";

    protected $fillable = [
        "name",
        "flat",
        "floor",
        "email",
        "organization_id",
        "description"
    ];

    protected $hidden = [
        "password"
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, "organization_id", "id");
    }
}
