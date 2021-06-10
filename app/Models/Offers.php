<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
	protected $table = 'offers';
	protected $fillable = ['id','title','from_date','to_date','description','offer_type','percentage','amount','gift','addon','vehicle','promocode','promocode_type','promocode_value','promocode_description'];
}