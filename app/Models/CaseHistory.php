<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseHistory extends Model
{
    use HasFactory;
    protected $table = "case_histories";
    protected $fillable = ['user_id', 'case_id', 'md_case_id', 'case_status', 'local_pharmacy', 'action_by'];
}
