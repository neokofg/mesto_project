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
        Schema::create('residents', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->timestamps();
            $table->string("name");
            $table->string("login")->unique();
            $table->string("flat");
            $table->string("floor");
            $table->string("email");
            $table->string("password");
            $table->foreignUuid("organization_id")->constrained("organizations")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resident');
    }
};
