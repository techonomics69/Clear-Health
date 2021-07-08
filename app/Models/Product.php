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
        'name', 'detail', 'status',
        'available_date', 'category_id', 'discount_price',
        'detail', 'quantity', 'min_quantity_alert',
        'image','image_detail', 'url', 'price', 'weight',
        'weight_unit','short_description','sub_title','upsell','product_active',
        'section1','section2','section3',
        'section1_title','section1_content','section1_image',
        'section2_title','section2_content','section2_image',
        'section3_title','section3_content','section3_image',
    ];

    

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}