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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_number', 30)->unique(); // e.g. B-05-36, A-26-21

            // Optional: parsed from unit_number for filtering/reporting
            $table->string('building_tower', 10)->nullable(); // A, B
            $table->unsignedTinyInteger('floor_level')->nullable();
            $table->string('room_number', 20)->nullable();    // 36, 21

            $table->foreignId('unit_type_id')->nullable()->constrained('unit_types')->nullOnDelete();
            $table->foreignId('unit_view_id')->nullable()->constrained('unit_views')->nullOnDelete();
            $table->foreignId('interior_type_id')->nullable()->constrained('interior_types')->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('owners')->nullOnDelete();

            // rental_status: vacant, monthly, daily (from KET: belum tersewa, bulanan, harian)
            $table->string('rental_status', 20)->default('vacant')->index();
            $table->unsignedInteger('occupancy_count')->default(0); // current tenants/occupants
            $table->text('issues')->nullable();   // Permasalahan: maintenance / problems
            $table->text('notes')->nullable();   // general notes

            $table->boolean('is_active')->default(true);
            $table->boolean('is_available')->default(true);   // for booking availability
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
