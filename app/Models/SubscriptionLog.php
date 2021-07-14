<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionLog extends Model
{
    use HasFactory;
    protected $table = 'subscription_log';

    protected $fillable = ['subscription_id','user_id','case_id','md_case_id','product_id','subscr_id',
                            'customer','plan_id','plan_amount','plan_currency','plan_interval',
                            'start_date','end_date','created'];
}
