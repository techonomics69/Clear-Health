<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurexaOrder extends Model
{
	protected $table = 'curexa_order';
	protected $fillable = ['id','order_id','rx_item_count','otc_item_count','status','message','order_status','status_details','tracking_number'];
}