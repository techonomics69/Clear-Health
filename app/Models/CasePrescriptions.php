<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasePrescriptions extends Model
{
    use HasFactory;
    protected $fillable = ['dosespot_prescription_id', 'dosespot_prescription_sync_status', 'dosespot_confirmation_status','dosespot_confirmation_status_details','refills','quantity','days_supply','no_substitutions','pharmacy_notes','directions','dispense_unit_id','preferred_pharmacy_id','partner_medication','prescription_medication_id','prescription_compound_id','user_id','case_id','system_case_id'];
}
