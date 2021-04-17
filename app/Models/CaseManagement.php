<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseManagement extends Model
{
    use HasFactory;
    protected $table = "case_managements";
    protected $fillable = ['ref_id', 'user_id', 'question_id', 'md_case_id', 'md_status', 'case_status'];
}
