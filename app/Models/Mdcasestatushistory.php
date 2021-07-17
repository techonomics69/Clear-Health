<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Mdcasestatushistory extends Model
{
    use HasFactory;

    protected $table = "md_case_status_history";
	protected $fillable = ['id','user_id','case_id','md_case_id','case_status','reason'];

}