<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('payment_type_id')->nullable()->constrained('payment_types')->nullOnDelete();

            $table->decimal('amount', 14, 2);
            $table->string('currency', 5)->default('IDR');
            $table->string('status', 30)->default('pending')->index();
            $table->timestamp('paid_at')->nullable();

            $table->string('gateway_name', 50)->nullable();
            $table->string('gateway_reference', 100)->nullable();
            $table->json('gateway_response')->nullable();

            $table->string('reference_number', 100)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
