<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $table= 'language';
    protected $fillable = ['name'];

    public function md_managment() {
	    return $this->hasMany('App\Models\Mdmanagement','id');
	}
}
