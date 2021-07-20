<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessages extends Model
{
    use HasFactory;
    protected $table = "support_messages";
    protected $fillable = ['user_id', 'case_id', 'md_case_id', 'text','from','channel', 'prioritized_at', 'prioritized_reason','message_created_at','case_message_id','message_files_ids','clinician'];
}
