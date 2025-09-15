<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    /** @use HasFactory<\Database\Factories\DistrictFactory> */
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = ['name', 'division_id'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

   public function users()
{
    return $this->belongsToMany(User::class, 'user_district');
}




}
