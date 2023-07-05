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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 35)->unique();
            $table->string('slug')->unique();
            $table->string('title')->unique();
            $table->text('description')->nullable();
            $table->float('base_price', unsigned: true)->startingValue(1);
            $table->tinyInteger('discount', unsigned: true)->nullable();
            $table->integer('quantity', unsigned: true)->default(0);
            $table->string('thumbnail_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
