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
        Schema::create('music', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->nullable($value=true);
            //$table->foreignId('category_id')->constrained('categories')->cascadeOnDelete()->nullable($value=true);
            //$table->foreignId('product_id')->constrained('products')->cascadeOnDelete()->nullable($value=true);
            $table->string('title');
            $table->text('description');
            $table->text('source');
            $table->text('cover_art');
            $table->text('artist');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music');
    }
};
