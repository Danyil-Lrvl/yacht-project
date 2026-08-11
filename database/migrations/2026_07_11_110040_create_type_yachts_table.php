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
        Schema::create('type_yachts', function (Blueprint $table) {
            $table->increments('id_type');
            $table->char('name_type', 50)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('image_path', 255)->nullable();
            $table->integer('max_passengers')->nullable();
            $table->string('length', 255)->nullable();
            $table->string('width', 255)->nullable();
            $table->integer('cabins')->nullable();
            $table->integer('heads')->nullable();
            $table->string('engine_power', 255)->nullable();
            $table->string('engine_model', 255)->nullable();
            $table->integer('year')->nullable();
            $table->string('condition', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_yachts');
    }
};