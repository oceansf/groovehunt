<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    public function definition(): array
    {
        $conditions = ['Mint', 'Near Mint', 'Very Good Plus', 'Very Good', 'Good Plus', 'Good', 'Fair', 'Poor'];
        $genres = ['Rock', 'Pop', 'Jazz', 'Classical', 'Folk', 'World', 'Country', 'Blues', 'Soul', 'Reggae', 'Hip Hop', 'Electronic', 'Latin', 'Funk / Soul', 'Non-Music', 'Children\'s', 'Brass & Military', 'Stage & Screen'];
        $speeds = ['33', '45', '16', '78'];
        $colors = ['Black', 'Blue', 'Brown', 'Clear', 'Gold', 'Green', 'Grey', 'Orange', 'Pink', 'Purple', 'Red', 'Silver', 'White', 'Yellow'];
        $formats = ['12-LP', '7-single', '10-LP', '12-single', '12-EP', '7-EP', '78-RPM', 'picture-disc', 'vinyl-box-set', 'cd-album', 'cd-single', 'cd-EP', 'sacd', 'cd-box-set', 'cassette', 'cassette-single', 'dat', 'cassette-box-set', '8-track', 'minidisc', 'reel-to-reel', 'dvd-audio', 'blu-ray-audio'];
        $statuses = ['available', 'sold', 'pending', 'reserved'];
        $allowOffers = $this->faker->boolean();
        
        // Generate a realistic price
        $price = $this->faker->randomFloat(2, 5, 200);
        
        return [
            // Existing fields with improved data generation
            'title' => $this->faker->words(rand(2, 6), true),  // More realistic title length
            'artist' => $this->faker->name(),
            'format' => $this->faker->randomElement($formats),
            'media_condition' => $this->faker->randomElement($conditions),
            'sleeve_condition' => $this->faker->randomElement($conditions),
            'description' => $this->faker->paragraphs(rand(1, 3), true),  // Longer description
            'images' => [
                'https://placehold.co/400x400/?text=Listing\nCover',
                'https://placehold.co/400x400/?text=Image\n2',
                'https://placehold.co/400x400/?text=Image\n3',
            ],
            'price' => $price,
            'allow_offers' => $allowOffers,
            'min_offer' => $allowOffers ? $price * 0.8 : null,  // More realistic minimum offer
            'shipping' => $this->faker->randomFloat(2, 3, 15),  // More realistic shipping cost
            'genre' => $this->faker->randomElement($genres),
            'speed' => $this->faker->randomElement($speeds),
            'color' => $this->faker->randomElement($colors),
            'release_country' => $this->faker->country(),
            'release_year' => $this->faker->year('now'),
            'release_label' => $this->faker->company(),  // More realistic label names
            'release_cat_no' => strtoupper($this->faker->bothify('??-####')),  // Format like "AB-1234"
            'release_matrix_no' => strtoupper($this->faker->bothify('??????##?')),  // Random matrix number
            'release_upc' => $this->faker->ean13(),  // Proper UPC format
            
            // New fields
            'status' => $this->faker->randomElement($statuses),
            'is_featured' => $this->faker->boolean(20),  // 20% chance of being featured
            'is_active' => $this->faker->boolean(90),    // 90% chance of being active
            'views_count' => $this->faker->numberBetween(0, 1000),
            'location' => $this->faker->city() . ', ' . $this->faker->state(),
            'local_pickup' => $this->faker->boolean(30), // 30% chance of local pickup
            'shipping_restrictions' => $this->faker->boolean(20) ? 
                $this->faker->randomElements(['US', 'CA', 'UK', 'EU', 'AU'], rand(1, 3)) : 
                [],
            'weight' => $this->faker->randomFloat(2, 0.2, 2),  // Weight in kg
            'notes' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'sold_at' => $this->faker->boolean(20) ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
            'last_price_update' => $this->faker->dateTimeBetween('-6 months', 'now'),
            
            // Foreign keys will be handled by the seeder
            'seller_id' => \App\Models\User::factory(),
            'buyer_id' => $this->faker->boolean(20) ? \App\Models\User::factory() : null,
        ];
    }

    /**
     * Indicate that the listing is sold
     */
    public function sold()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'sold',
            'buyer_id' => \App\Models\User::factory(),
            'sold_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_active' => false
        ]);
    }

    /**
     * Indicate that the listing is featured
     */
    public function featured()
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
            'is_active' => true
        ]);
    }

    /**
     * Create an inactive listing
     */
    public function inactive()
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false
        ]);
    }
}