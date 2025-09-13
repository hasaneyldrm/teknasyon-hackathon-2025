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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->char('user_uuid', 36)->index();
            $table->text('message');
            $table->text('response');
            $table->string('conversation_id')->index();
            $table->string('model')->default('gpt-3.5-turbo');
            $table->integer('tokens_used')->default(0);
            $table->float('response_time')->default(0);
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();

            $table->index(['user_uuid', 'conversation_id']);
            $table->index(['project_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
