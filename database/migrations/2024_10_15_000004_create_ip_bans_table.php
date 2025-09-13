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
        Schema::create('ip_bans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip_address')->unique();
            $table->enum('type', ['temporary', 'permanent'])->default('temporary');
            $table->text('reason');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();

            $table->index(['ip_address', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_bans');
    }
};
