<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Birthcontrolanswer extends Model
{
    use HasFactory;
    protected $table="birthcontrol_answer";

    protected $fillable = ["user_id","case_id","md_case_id","answer","left_face",
                        "left_face_file_id","right_face","right_face_file_id","center_face",
                        "center_face_file_id","back_photo","back_photo_file_id","chest_photo",
                        "chest_photo_file_id","last_step"];
}
