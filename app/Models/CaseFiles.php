<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseFiles extends Model
{
    use HasFactory;
    protected $table = "case_files";
    protected $fillable = ['name', 'file', 'case_id', 'url', 'url_thumbnail', 'file_id','mime_type','system_case_id','system_file','user_id'];
}
