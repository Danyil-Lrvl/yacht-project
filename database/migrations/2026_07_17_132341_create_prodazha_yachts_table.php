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
        Schema::create('prodazha_yachts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yacht_id');
            $table->unsignedBigInteger('client_id');
            $table->date('sale_date')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['заявка', 'оплачено', 'отримано покупцем', 'анульовано'])->default('заявка');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodazha_yachts');
    }
};