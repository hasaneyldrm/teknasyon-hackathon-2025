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
        Schema::create('request_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_uuid', 36)->nullable();
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->string('ip_address');
            $table->string('method');
            $table->string('path');
            $table->text('request_data')->nullable();
            $table->integer('response_code');
            $table->text('response_data')->nullable();
            $table->integer('response_time');
            $table->string('user_agent')->nullable();
            $table->string('action');
            $table->text('error_message')->nullable();
            $table->json('security_flags')->nullable();
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();

            $table->index(['ip_address', 'created_at']);
            $table->index(['user_uuid', 'created_at']);
            $table->index(['project_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_logs');
    }
};
