<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageFiles extends Model
{
    use HasFactory;
    protected $fillable = ['msg_id', 'file_path', 'file_name','mime_type','thumbnail'];
}
