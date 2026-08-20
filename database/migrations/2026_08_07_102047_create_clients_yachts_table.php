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
        Schema::create('clients_yachts', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100)->unique(); // Пошта для входу має бути унікальною
            $table->string('password'); // Поле для збереження пароля
            $table->string('full_name')->nullable(); // Повне ім'я (може заповнюватись у профілі)
            $table->string('document_number', 50)->nullable();
            $table->string('document_issued_by', 255)->nullable();
            $table->date('document_date')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('tax_id', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients_yachts');
    }
};