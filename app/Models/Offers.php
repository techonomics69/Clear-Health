<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
	protected $table = 'offers';
	protected $fillable = ['id','from_date','to_date','description','promocode','promocode_type','promocode_value'];
}