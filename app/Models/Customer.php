<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['partner_id','first_name','last_name','gender','date_of_birth','phone_number','phone_type','email','address','city_id','zip_code','weight','height'];
}
