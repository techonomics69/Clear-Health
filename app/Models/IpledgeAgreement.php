<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpledgeAgreement extends Model
{
	protected $table = 'ipledge_agreement';
	protected $fillable = ['id','user_id','case_id','md_case_id','patient_name','answer','doctor_name','patients_signature','patients_signature_date','guardians_signature','guardians_signature_date'];
}