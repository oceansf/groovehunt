<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Listing extends Model
{
    /** @use HasFactory<\Database\Factories\ListingFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'artist',
        'format',
        'media_condition',
        'sleeve_condition',
        'description',
        'images',
        'price',
        'allow_offers',
        'min_offer',
        'shipping',
        'genre',
        'speed',
        'color',
        'release_country',
        'release_year',
        'release_label',
        'release_cat_no',
        'release_matrix_no',
        'release_upc',
        'status',
        'is_active',
        'location',
        'local_pickup',
        'shipping_restrictions',
        'weight',
        'notes',
        'seller_id',
        'buyer_id'
    ];

    protected $casts = [
        'images' => 'array',
        'shipping_restrictions' => 'array',
        'allow_offers' => 'boolean',
        'local_pickup' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'shipping' => 'decimal:2',
        'min_offer' => 'decimal:2',
        'weight' => 'decimal:2',
        'sold_at' => 'datetime',
        'last_price_update' => 'datetime',
    ];

    /**
     * Get the user who created this listing (seller)
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the user who purchased this listing (buyer)
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

}
