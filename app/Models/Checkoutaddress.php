<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkoutaddress extends Model
{
    use HasFactory;
    protected $table = "checkout_address";
    protected $fillable = ['id','user_id', 'case_id', 'patient_firstname', 'patient_lastname', 'addressline1', 'addressline2','city','state','zipcode','phone','email','address_type'];
}
