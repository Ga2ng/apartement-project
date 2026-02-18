<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number', 50)->unique();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('guest_name');
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            $table->string('guest_id_type', 30)->nullable();
            $table->string('guest_id_number', 50)->nullable();
            $table->text('guest_address')->nullable();

            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->unsignedSmallInteger('number_of_guests')->nullable();
            $table->unsignedSmallInteger('total_nights');

            $table->string('status', 30)->default('draft')->index();
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('discount_amount', 14, 2)->default(0);
            $table->foreignId('promo_id')->nullable()->constrained('promos')->nullOnDelete();
            $table->decimal('tax_amount', 14, 2)->default(0);
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->string('currency', 5)->default('IDR');

            $table->foreignId('payment_type_id')->nullable()->constrained('payment_types')->nullOnDelete();

            $table->string('source', 30)->default('admin')->nullable();
            $table->text('special_requests')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
