<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetUser extends Model
{
    // Nama tabel persis seperti di migration
    protected $table = 'asset_user';

    // Primary key ganda sudah ditetapkan di migration,
    // jadi disable "incrementing" & "keyType".
    public $incrementing = false;
    protected $keyType    = 'string';  // atau 'int' jika PK integer

    protected $fillable = ['user_id', 'asset_id'];
}
