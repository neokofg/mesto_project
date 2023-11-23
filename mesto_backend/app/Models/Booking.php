<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory, HasUuids;

    protected $table = "bookings";

    protected $fillable = [
      "format",
      "number",
      "email",
      "clients",
      "fromDate",
      "toDate",
      "status",
      "organization_id"
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, "organization_id", "id");
    }

    public function excursion(): BelongsTo
    {
        return $this->belongsTo(Excursion::class, "excursion_id","id");
    }
}
