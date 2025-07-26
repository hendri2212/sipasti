<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Institution;
use Illuminate\Database\Eloquent\Model;

class Member extends Model {
    // protected $fillable = ['name', 'phone', 'address', 'institution_id'];
    protected $fillable = ['name', 'phone', 'address'];

    // public function institution(): BelongsTo {
    //     return $this->belongsTo(Institution::class);
    // }
}