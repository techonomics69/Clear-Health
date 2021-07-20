<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyLog extends Model
{
    use HasFactory;
    protected $table = 'pharmacy_change_log';

    protected $fillable = ['cart_id','case_id','md_case_id','user_id','product_id','pharmacy_pickup',"is_first"];
}
