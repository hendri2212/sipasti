<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalAsset extends Model {
    protected $fillable = [
        'institution_id',
        'member_id',
        'asset_id',
        'photo',
    ];
}
