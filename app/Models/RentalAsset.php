<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institution;
use App\Models\Asset;
use App\Models\Member;

class RentalAsset extends Model {
    protected $fillable = [
        'member_id',
        'institution_id',
        'asset_id',
        'photo',
        'start_at',
        'end_at',
        'status',
        'letter_number',
        'letter_date',
        'incoming_letter_date',
        'recommendation',
        'regarding',
        'recommendation_letter',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'letter_date' => 'date',
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