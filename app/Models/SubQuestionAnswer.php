<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class SubQuestionAnswer extends Model
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $table= 'sub_question_answer';
    protected $fillable = [
        'parent_question_id','question_id', 'option_select',
    ];
    public function Quiz()
    {
        return $this->belongsTo('App\Models\Quiz', 'question_id');
    }
}