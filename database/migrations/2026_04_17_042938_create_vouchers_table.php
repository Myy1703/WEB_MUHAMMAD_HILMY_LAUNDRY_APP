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
        /*
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code', 50)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('valid_until');
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /* Schema::dropIfExists('vouchers'); */
    }
};
