<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_base_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->date('effective_from');
            $table->date('effective_until')->nullable();
            $table->decimal('daily_rate', 14, 2);
            $table->string('currency', 5)->default('IDR');
            $table->unsignedSmallInteger('min_nights')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['unit_id', 'effective_from', 'effective_until']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_base_rates');
    }
};
