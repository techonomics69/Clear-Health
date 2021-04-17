<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Mdmanagement extends Model
{
    use HasFactory;

    protected $table = "md_managment";
	protected $fillable = ['id','name', 'image', 'status', 'language_id', 'case_id'];

	 public function language()
    {
        return $this->belongsTo('App\Models\Language', 'language_id');
    }

}