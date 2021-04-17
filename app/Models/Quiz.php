<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'question', 'answer', 'option', 'status', 'category_id','options_type','min_number', 'max_number'];

    public function category()
    {
        return $this->belongsTo('App\Models\QuizCategory', 'category_id');
    }
}
