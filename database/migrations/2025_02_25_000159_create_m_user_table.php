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
        Schema::create('m_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->unsignedBigInteger('id_level');
            $table->string('username', 20)->unique();
            $table->string('name', 100);
            $table->string('password');
            $table->string('profile_image')->nullable();
            $table->timestamps();

            $table->foreign('id_level')->references('id_level')->on('m_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_user', function (Blueprint $table) { // Add this to safely drop column if needed
            $table->dropForeign(['id_level']); // Drop foreign key first
            $table->dropColumn('profile_image');
        });
        Schema::dropIfExists('m_user'); // Keep original drop table
    }
};
