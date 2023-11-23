<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organization extends Model
{
    use HasFactory, HasUuids;

    protected $table = "organizations";

    protected $fillable = [
      "name"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id","id");
    }

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class, "organization_id", "id");
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, "organization_id", "id");
    }
}
