<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    use HasFactory;

    protected $table="fees";

    protected $fillable = [
        'id','title', 'amount','fee_type','status'];

}
