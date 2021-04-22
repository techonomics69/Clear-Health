<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
     protected $table= 'quizzes';
    protected $fillable = [
        'question','sub_question','sub_heading','option','sub_question','use_for_recommendation','recommendation_product', 'status', 'category_id','options_type','min_number', 'max_number'];

    public function category()
    {
        return $this->belongsTo('App\Models\QuizCategory', 'category_id');
    }
}
