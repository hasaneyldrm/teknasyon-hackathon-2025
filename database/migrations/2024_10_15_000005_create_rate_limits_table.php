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
        Schema::create('rate_limits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->comment('Rate limit key (IP, API key, etc.)');
            $table->string('type')->comment('Rate limit type: burst, daily, monthly');
            $table->integer('current_count')->default(0);
            $table->integer('max_count');
            $table->timestamp('window_start')->nullable();
            $table->timestamp('window_end')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->timestamp('blocked_until')->nullable();
            $table->timestamps();

            $table->index(['is_blocked', 'blocked_until']);
            $table->unique(['key', 'type']);
            $table->index(['key', 'window_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_limits');
    }
};
