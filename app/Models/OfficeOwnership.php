<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeOwnership extends Model
{
    protected $table = 'office_ownership';

    protected $fillable = ['id_office','id_asset'];

    public function office()
    {
        return $this->belongsTo(Office::class, 'id_office');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id_asset');
    }
}
