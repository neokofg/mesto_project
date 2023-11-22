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
        Schema::create('users_verify', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->timestamps();
            $table->integer("code");
            $table->string("email");
            $table->foreignUuid("user_id")->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_verify');
    }
};
