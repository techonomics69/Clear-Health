<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPics extends Model
{
    use HasFactory;
    protected $table = "user_picture";
    protected $fillable = ['user_id', 'case_id', 'left_pic', 'right_pic','straight_pic'];
}
