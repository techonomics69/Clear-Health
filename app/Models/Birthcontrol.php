<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Birthcontrol extends Model
{
    use HasFactory;
    protected $table = 'birthcontrol';

    protected $fillable = ['user_name','user_id'];
}
