<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Userpromocode extends Model
{
    use HasFactory;

    protected $table = "user_promocode";
	protected $fillable = ['id','promocode','user_id'];

}