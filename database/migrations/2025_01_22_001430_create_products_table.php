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
            $table->foreignID("category_id")
            ->references("id")
            ->on("categories")
            ->cascade("delete")
            ->cascade("update");
            $table->string("product_name");
            $table->string("product_image");
            $table->string("product_image_name");
            $table->double("price");
            $table->integer("stock");
            $table->text("description");
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
