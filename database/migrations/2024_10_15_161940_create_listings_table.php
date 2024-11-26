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
            $table->string('format');  // e.g., LP, 45, 78
            $table->string('media_condition');
            $table->string('sleeve_condition')->nullable();
            $table->text('description')->nullable();  // Changed from char(300) to text for more flexibility
            $table->json('images');
            $table->decimal('price', 8, 2);
            $table->boolean('allow_offers')->default(false);
            $table->decimal('min_offer', 8, 2)->nullable();
            $table->decimal('shipping', 8, 2);
            $table->string('genre')->nullable();
            $table->string('speed')->nullable();  // e.g., 33, 45, 78
            $table->string('color')->nullable();
            $table->string('release_country')->nullable();
            $table->string('release_year')->nullable();
            $table->string('release_label')->nullable();
            $table->string('release_cat_no')->nullable();
            $table->string('release_matrix_no')->nullable();
            $table->string('release_upc')->nullable();

            $table->string('status')->default('available');  // available, sold, pending, reserved
            $table->boolean('is_featured')->default(false);  // For premium/featured listings
            $table->boolean('is_active')->default(true);     // To temporarily hide/deactivate listings
            $table->integer('views_count')->default(0);      // Track listing views
            $table->string('location')->nullable();                      // Seller's location for local pickup options
            $table->boolean('local_pickup')->default(false); // Allow local pickup option
            $table->json('shipping_restrictions')->nullable(); // Countries/regions where shipping is not available
            $table->decimal('weight', 8, 2)->nullable();     // For shipping calculations
            $table->text('notes')->nullable();               // Internal notes or additional details
            $table->timestamp('sold_at')->nullable();        // When the item was sold
            $table->timestamp('last_price_update')->nullable(); // Track price changes

            $table->foreignId('seller_id')->constrained('users');
            $table->foreignId('buyer_id')->nullable()->constrained('users');
            
            // Indexes for better query performance
            $table->index('artist');
            $table->index('genre');
            $table->index('format');
            $table->index('status');
            $table->index(['is_active', 'status']);
            $table->index('release_year');
            
            $table->timestamps();
            $table->softDeletes(); // Add soft deletes for record keeping
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
