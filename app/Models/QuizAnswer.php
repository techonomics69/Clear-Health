<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id', 'answer', 'user_id', 'case_id'];

    public function question()
    {
        return $this->belongsTo('App\Models\Quiz', 'question_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function case()
    {
        return $this->belongsTo('App\Models\CaseManagement', 'case_id');
    }
}
