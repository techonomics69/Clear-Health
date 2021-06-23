<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	protected $table = 'subscription';
	protected $fillable = ['id','user_id','case_id','md_case_id','subscr_id','customer','plan_id','plan_amount','plan_currency','plan_interval','plan_interval_count','created','current_period_start','current_period_end','status','product_id','subscribed_at','renew_at'];
}