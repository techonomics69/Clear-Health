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
        'imp_info_title', 'imp_info_content', 'section1_button_show',
        'section1_button_content', 'section2_button_show', 'section2_button_content',
        'section3_button_show', 'section3_button_content',
        'section1_button_link','section2_button_link','section3_button_link'
    ];

    

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}