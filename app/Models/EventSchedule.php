<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RentalAsset;

class EventSchedule extends Model {
    
    use HasFactory;

    protected $fillable = ['rental_asset_id', 'date', 'start_time', 'end_time'];

    public function rentalAsset() {
        return $this->belongsTo(RentalAsset::class);
    }
}