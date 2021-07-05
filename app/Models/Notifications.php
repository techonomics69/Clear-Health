<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable = ['user_id', 'case_id','md_case_id','order_id','read_at','noti_message','for_month'];
}
