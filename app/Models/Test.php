<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable = ['id','name'];

    public function quiz() {
	    return $this->hasMany('App\Models\Quiz', 'id');
	}
}
