<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentGuides extends Model
{
    use HasFactory;
    protected $table = "treatment_guides";
    protected $fillable = ['id', 'title', 'sub_title', 'status', 'detail','guides_image'];
}