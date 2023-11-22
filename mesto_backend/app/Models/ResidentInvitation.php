<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResidentInvitation extends Model
{
    use HasFactory, HasUuids;

    protected $table = "resident_invitation";

    protected $fillable = [
        "hash",
        "name",
        "flat",
        "floor",
        "email",
        "organization_id",
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, "organization_id", "id");
    }
}
