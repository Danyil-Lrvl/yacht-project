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
        Schema::create('yachts', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // Назва яхти
            $table->string('serial_number', 50)->nullable(); // Серійний номер
            $table->integer('year')->nullable();           // Рік випуску
            $table->string('status', 20)->nullable()->default('available'); // Статус
            $table->decimal('price_rent', 10, 2)->nullable();// Ціна оренди
            $table->decimal('price_buy', 10, 2)->nullable(); // Ціна покупки
            $table->date('last_maintenance')->nullable();   // Дата останнього обслуговування
            $table->string('type_oper')->nullable();       // Тип операції (rent / buy)
            $table->integer('type_id')->nullable();        // ID типу
            $table->date('registration_date')->nullable(); // Дата реєстрації
            $table->tinyInteger('is_active')->nullable();  // Активність
            $table->text('comment')->nullable();           // Коментар / "плюшки"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yachts');
    }
};