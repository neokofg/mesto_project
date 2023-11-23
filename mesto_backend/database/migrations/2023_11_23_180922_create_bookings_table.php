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
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->timestamps();
            $table->enum("format", ["school","university","individual"]);
            $table->string("number");
            $table->string("email");
            $table->integer("clients");
            $table->date("fromDate");
            $table->date("toDate");
            $table->dateTime("exTime")->nullable();
            $table->enum("status", ["pending","accepted", "declined"])->default('pending');
            $table->foreignUuid('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('excursion_id')->nullable()->constrained('excursions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
