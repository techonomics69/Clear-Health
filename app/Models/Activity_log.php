<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_log extends Model
{
    use HasFactory;
    protected $table = 'activity_log';

    protected $fillable = ['user_type','action_module','action','user_id','description','ref_id','case_id','md_case_id'];
}
