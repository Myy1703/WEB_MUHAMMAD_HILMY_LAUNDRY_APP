<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TypeOfService;


return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trans_order_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_order');
            $table->unsignedBigInteger('id_service');
            $table->integer('qty'); // berat dalam kg
            $table->double('subtotal', 10, 2); // harga * qty
            $table->enum('status', ['pending', 'diproses', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('id_order')->references('id')->on('trans_order');
            $table->foreign('id_service')->references('id')->on('type_of_service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_order_detail');
    }
};
