<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;
    protected $fillable = ['name', 'address', 'email','phone','district_id','created_by, image'];

   public function district()
{
    return $this->belongsTo(District::class);
}


public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}
}