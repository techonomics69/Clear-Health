<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Iatstuti\Database\Support\NullableFields;
  
class Product extends Model
{
    use HasFactory, NullableFields;
  
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'name', 'detail', 'status', 'available_date', 'category_id', 'discount_price', 'detail', 'quantity', 'min_quantity_alert', 'image','image_detail', 'url', 'price', 'weight', 'weight_unit','short_description','sub_title','upsell','product_active',
    ];

    protected $nullable = [
        'section1',
        'section2',
        'section3',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}