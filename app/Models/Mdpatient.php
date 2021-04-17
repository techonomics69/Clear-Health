<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mdpatient extends Model
{
    use HasFactory;

     protected $table = "md_patient";
     
    protected $fillable = [
        'id','partner_id', 'first_name', 'last_name', 'email','gender','phone_number','phone_type','date_of_birth', 'active','weight','height','dosespot_sync_status','patient_id','gender_label','address','zip_code','city_id','city_name','state_name','state_abbreviation'];

}
