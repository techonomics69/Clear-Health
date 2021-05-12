<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdMessageFiles extends Model
{
    use HasFactory;
    protected $table = "md_message_files";
    protected $fillable = ['user_id', 'case_id', 'md_case_id', 'system_file','name','url', 'url_thumbnail', 'file_id','mime_type'];
}
