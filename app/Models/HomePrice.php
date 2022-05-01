<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class HomePrice extends Model
{
    use HasUUID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'price',
        'bedrooms',
        'bathrooms',
        'sqft_living',
        'sqft_lot',
        'floors',
        'waterfront',
        'view',
        'condition',
        'sqft_above',
        'sqft_basement',
        'year_built',
        'year_renovated',
        'street',
        'city',
        'state_zip',
        'country',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'standardized_price',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];

    /**
     * Get standardized price attribute value
     *
     * @return float
     */
    public function getStandardizedPriceAttribute()
    {
        $currentYear = Carbon::now()->format('Y');

        $expression1 = ($this->bedrooms * $this->bathrooms * ($this->sqft_living / $this->sqft_lot) * $this->floors)
            + $this->waterfront + $this->view;
        $expression2 = $this->sqft_above + $this->sqft_basement;
        $expression3 = 10 * ($currentYear - max($this->year_built, $this->year_renovated));

        return round((($expression1 * $this->condition * $expression2) - $expression3) * 100, 2);
    }
}
