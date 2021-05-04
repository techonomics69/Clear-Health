<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mdcases extends Model
{
    use HasFactory;
    protected $table = 'md_cases';
    protected $fillable = ['prioritized_at', 'prioritized_reason', 'cancelled_at', 'md_created_at', 'support_reason', 'case_id', 'status','user_id','system_case_id'];
}
