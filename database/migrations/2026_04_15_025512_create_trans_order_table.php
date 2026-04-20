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
        Schema::create('trans_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_customer');
            $table->string('order_code', 50);
            $table->date('order_date');
            $table->date('order_end_date');
            $table->tinyInteger('order_status')->default(0); // 0=baru, 1=diambil
            $table->timestamps();
            $table->softDeletes();
            $table->integer('order_pay')->nullable();
            $table->integer('order_change')->nullable();
            $table->integer('total')->nullable();
            /*
            $table->integer('pajak_persen')->nullable()->default(0); 
            $table->integer('pajak_nominal')->nullable()->default(0);
            */
            
            $table->integer('member_discount_persen')->nullable()->default(0);
            $table->integer('member_discount_nominal')->nullable()->default(0);
            
            /*
            $table->string('voucher_code', 50)->nullable();
            $table->integer('voucher_discount_persen')->nullable()->default(0);
            $table->integer('voucher_discount_nominal')->nullable()->default(0);
            */

            $table->foreign('id_customer')->references('id')->on('customers');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_order');
    }
};
