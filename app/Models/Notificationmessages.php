<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificationmessages extends Model
{
    use HasFactory;
    protected $table = "notification_messages";

    protected $fillable = ['key', 'message'];

}
