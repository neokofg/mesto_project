<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resident_invitation', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->timestamps();
            $table->string("hash")->unique();
            $table->string("name");
            $table->string("flat");
            $table->string("floor");
            $table->string("email");
            $table->foreignUuid("organization_id")->constrained("organizations")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident_invitation');
    }
};
