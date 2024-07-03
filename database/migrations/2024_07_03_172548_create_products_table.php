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
            $table->string('category_uuid'); // foreign key (categories.uuid)
            $table->foreign('category_uuid')->references('uuid')->on('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('uuid')->unique()->index();
            $table->string('title');
            $table->float('price', 2);
            $table->text('description');
            $table->json('metadata');
            $table->softDeletes();
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
