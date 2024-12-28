<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recommendation extends Model
{
    protected $table = 'recommendation';

    protected $fillable = ['id_user', 'id_admin', 'required_item', 'category', 'id_asset', 'status', 'description', 'admin_reply', 'approved_at', 'completed_at','attachment','purpose_of'];

    public function user()
    {
        return $this->BelongsTo(User::class, 'id_user');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'id_asset');
    }
}
