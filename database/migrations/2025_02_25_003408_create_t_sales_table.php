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
        Schema::create('t_sales', function (Blueprint $table) {
            $table->id('id_sales');
            $table->unsignedBigInteger('id_user');
            $table->string('buyer', 50);
            $table->string('sales_code', 50)->unique();
            $table->dateTime('sales_date');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sales');
    }
};
