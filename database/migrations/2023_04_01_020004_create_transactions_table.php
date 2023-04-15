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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment('1 = sale, 2 = purcahse');
            $table->datetime('transaction_date');
            $table->string('code')->nullable();
            $table->integer('product_id');
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('total');
            $table->text('notes')->nullable();
            $table->integer('user_id');
            $table->json('ref')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
