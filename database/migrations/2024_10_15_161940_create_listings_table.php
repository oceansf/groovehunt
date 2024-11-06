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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist');
            $table->string('format');
            $table->string('media_condition');
            $table->string('sleeve_condition');
            $table->char('description', length: 300);
            $table->string('images');
            $table->decimal('price', 8, 2);
            $table->boolean('allow_offers')->default(false);
            $table->decimal('min_offer', 8, 2)->nullable();
            $table->decimal('shipping', 8, 2);
            $table->string('genre');
            $table->string('speed');
            $table->string('color');
            $table->string('release_country')->nullable();
            $table->string('release_year')->nullable();
            $table->string('release_label')->nullable();
            $table->string('release_cat_no')->nullable();
            $table->string('release_matrix_no')->nullable();
            $table->string('release_upc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
