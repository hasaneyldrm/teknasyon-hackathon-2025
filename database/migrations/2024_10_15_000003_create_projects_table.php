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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 512)->index();
            $table->string('api_key', 512)->index();
            $table->float('temperature')->default(0.7)->index();
            $table->integer('max_token')->default(1000)->index();
            $table->string('image', 512)->nullable();
            $table->text('description')->nullable();
            $table->string('model')->default('gpt-3.5-turbo');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
