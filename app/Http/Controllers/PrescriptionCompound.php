<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionCompound extends Model
{
    use HasFactory;
    protected $fillable = ['partner_compound_id', 'title', 'case_prescription_id'];
}
