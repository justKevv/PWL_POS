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
        Schema::create('t_stock', function (Blueprint $table) {
            $table->id('id_stock');
            $table->unsignedBigInteger('id_product');
            $table->unsignedBigInteger('id_user');
            $table->dateTime('date_stock');
            $table->integer('stock_quantity');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('m_user');
            $table->foreign('id_product')->references('id_product')->on('m_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_stock');
    }
};
