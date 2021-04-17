<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parentdetail extends Model
{
    use HasFactory;

     protected $table="parents_details";

    protected $fillable = ['id','user_id','first_name','last_name','email','phone'];

}
