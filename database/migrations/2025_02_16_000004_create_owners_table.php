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
        Schema::create('owners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);          // e.g. BED DEBT, UNSOLD-PPA
            $table->string('code', 30)->unique(); // e.g. bed_debt, unsold_ppa
            $table->string('contact_name', 100)->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->string('contact_email', 100)->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners');
    }
};
