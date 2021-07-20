<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportMessagesFiles extends Model
{
    use HasFactory;
    protected $table = "support_messages_files";
    protected $fillable = ['user_id', 'case_id', 'md_case_id', 'system_file','name','url', 'url_thumbnail', 'file_id','mime_type'];
}
