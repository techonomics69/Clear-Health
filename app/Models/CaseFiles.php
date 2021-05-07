<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseFiles extends Model
{
    use HasFactory;
    protected $table = "case_files";
    protected $fillable = ['name', 'file', 'case_id', 'url', 'url_thumbnail', 'file_id','mime_type','system_case_id','system_file','user_id','md_file_name','md_mime_type','md_url','md_url_thumbnail','md_file_id'];
}
