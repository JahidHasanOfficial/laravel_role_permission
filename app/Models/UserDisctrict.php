<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDisctrict extends Model
{
    /** @use HasFactory<\Database\Factories\UserDisctrictFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'district_id'
    ];
}
