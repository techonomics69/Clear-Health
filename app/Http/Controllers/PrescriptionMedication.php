<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionMedication extends Model
{
    use HasFactory;
    protected $fillable = ['case_prescription_id', 'dosespot_medication_id', 'dispense_unit_id','dose_form','route','strength','generic_product_name','lexi_gen_product_id','lexi_drug_syn_id','lexi_synonym_type_id','lexi_gen_drug_id','rx_cui','otc','ndc','schedule','display_name','monograph_path','drug_classification','state_schedules'];
}
