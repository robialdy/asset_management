<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';

    protected $fillable = ['code_asset','name','category','description','added_date','sent_date','return_date','destroy_date','status','slug','image'];

    public static function generateCodeAsset()
    {
        $date = now();
        $formatDate = $date->format('dmy');

        $lastAsset = self::where('code_asset', 'like', "%/$formatDate/%")
        ->orderByRaw("CAST(SUBSTRING_INDEX(code_asset, '/', -1) AS UNSIGNED) DESC")
        ->first();

        if ($lastAsset) {
            $lastCode = $lastAsset->code_asset;
            $lastIncrement = (int)substr($lastCode, -3);
            $newIncrement = $lastIncrement + 1;
        } else {
            $newIncrement = 1;
        }

        return sprintf("#JNE/A/$formatDate/%03d", $newIncrement);
    }

    public function details()
    {
        return $this->hasMany(Detail_Asset::class, 'id_asset', 'id');
    }
}
