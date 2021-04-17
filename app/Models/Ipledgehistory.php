<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipledgehistory extends Model
{
    use HasFactory;

     protected $table="ipledges_history";public $timestamps = true;

    protected $fillable = ['id','files','imported_by','patients_type'];

}
