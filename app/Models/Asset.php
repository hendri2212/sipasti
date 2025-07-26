<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Asset extends Model {
    /** @use HasFactory<\Database\Factories\AssetFactory> */
    // use HasFactory;

    public function users() {
        return $this->belongsToMany(User::class, 'asset_user', 'asset_id', 'user_id');
    }
}