<?php

namespace App\Models;

use App\Models\Office;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'Users';

    protected $fillable = ['username','department','email','full_name','phone','role','password','id_office'];

    public function joinOffice()
    {
        return $this->belongsTo(Office::class, 'id_office');
    }
}
