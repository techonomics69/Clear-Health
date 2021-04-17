<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipledge extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','patient_id', 'addon_date', 'addon_by', 'patient_name','patients_type','gender','assigned_date','assigned_by', 'notes','pregnancy_test','blood_work','i_pledge_agreement'];

}
