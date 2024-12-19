<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_Asset extends Model
{
    protected $table = 'detail_asset';

    protected $fillable = ['id_asset','title','description'];
}
