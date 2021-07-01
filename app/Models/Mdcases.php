<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mdcases extends Model
{
    use HasFactory;
    protected $table = 'md_cases';
    protected $fillable = ['prioritized_at', 'prioritized_reason', 'cancelled_at', 'md_created_at', 'support_reason', 'case_id', 'status','case_status_reason','case_status_updated_at','user_id','system_case_id'];

    public function caseManagement()
	{
	    return $this->hasOne('App\Models\CaseManagement','id');
	}
}
