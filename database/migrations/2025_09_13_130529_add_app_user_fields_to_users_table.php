<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
            $table->integer('coin')->default(0)->after('email_verified_at');
            $table->string('token')->nullable()->after('coin');
            $table->string('app_source')->nullable()->after('token');
        });
        
        // Mevcut kullanıcılara UUID ata ve sonra unique constraint ekle
        DB::statement('UPDATE users SET uuid = UUID() WHERE uuid IS NULL');
        
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'coin', 'token', 'app_source']);
        });
    }
};
