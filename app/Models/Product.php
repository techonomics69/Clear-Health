<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
class Product extends Model
{
    use HasFactory;
  
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'name', 'detail', 'status', 'available_date', 'category_id', 'discount_price', 'detail', 'quantity', 'min_quantity_alert', 'image','image_detail', 'url', 'price', 'weight', 'weight_unit','short_description','sub_title','upsell','product_active',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}