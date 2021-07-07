<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
	protected $table = 'follow_up';
	protected $fillable = ['id','user_id','case_id','answer','left_face','right_face','center_face','back_photo','chest_photo','follow_up_status','follow_up_no','pregnancy_test', 'pregnancy_test_verify','left_face_file_id','right_face_file_id','center_face_file_id','back_photo_file_id','chest_photo_file_id','pregnancy_test_file_id'];
}