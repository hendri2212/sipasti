<?php

namespace App\Models;

use App\Models\User;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class AssetUser extends Model {
    protected $table = 'asset_user';

    public $incrementing = false;
    protected $keyType    = 'string';

    protected $fillable = ['user_id', 'asset_id'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asset(): BelongsTo {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
