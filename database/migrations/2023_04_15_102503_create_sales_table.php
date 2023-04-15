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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->datetime('sale_date');
            $table->string('code')->nullable();
            $table->integer('product_id');
            $table->integer('price');
            $table->integer('quantity');
            $table->bigInteger('total')->nullable();
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
        Schema::dropIfExists('sales');
    }
};
