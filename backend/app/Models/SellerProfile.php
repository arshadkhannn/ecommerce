<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class SellerProfile extends Model
{
    //
    protected $fillable=[
        'user_id',
        'business_name',
        'phone',
        'address',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
