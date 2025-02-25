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
        Schema::create('t_sales_detail', function (Blueprint $table) {
            $table->id('id_sales_detail');
            $table->unsignedBigInteger('id_sales');
            $table->unsignedBigInteger('id_product');
            $table->integer('price');
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('id_sales')->references('id_sales')->on('t_sales');
            $table->foreign('id_product')->references('id_product')->on('m_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sales_detail');
    }
};
