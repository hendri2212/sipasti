<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institution;
use App\Models\Asset;
use App\Models\Member;

class RentalAsset extends Model {
    protected $fillable = [
        'institution_id',
        'member_id',
        'asset_id',
        'status',
        'photo',
    ];

    /**
     * Get the institution that owns the rental.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the asset that is rented.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    /**
     * Get the member who made the rental.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}