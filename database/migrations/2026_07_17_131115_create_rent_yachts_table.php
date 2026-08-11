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
        Schema::create('rent_yachts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yacht_id');
            $table->unsignedBigInteger('client_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamp('operation_date')->useCurrent();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['заявка', 'оплачено', 'анульовано'])->default('заявка');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_yachts');
    }
};