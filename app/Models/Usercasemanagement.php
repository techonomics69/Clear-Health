<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usercasemanagement extends Model
{
    use HasFactory;

    protected $table="user_case_management";

    protected $fillable = [
        'id','ref_id', 'user_id', 'question_id', 'md_case_id','md_status'];

}
