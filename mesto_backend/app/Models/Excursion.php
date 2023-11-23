<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Excursion extends Model
{
    use HasFactory, HasUuids;

    protected $table = "excursions";

    protected $fillable = [
        "exDate"
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, "organization_id", "id");
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, "excursion_id", "id");
    }
}
