<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetOwnership extends Model
{
    protected $table = 'asset_ownership';

    protected $fillable = ['id_user', 'id_asset'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id_asset');
    }
}
