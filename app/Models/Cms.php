<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    use HasFactory;
    protected $table = 'cms_pages';
    protected $fillable = ['title', 'description', 'url', 'meta_title', 'meta_description', 'meta_keyword', 'status'];
}
