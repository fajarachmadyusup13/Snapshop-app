<?php

namespace Snapshop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'barcode',
        'product_name',
        'description',
        'price',
        'stock',
        'pict',
        'brand_id',
        'category_id',
    ];

    public function orders()
    {
        return $this->hasMany('Snapshop\Models\Order','product_id','id');
    }

    /**
     * Get the brand that the product belongs to.
     */
    public function brand()
    {
        return $this->belongsTo('Snapshop\Models\Brand','brand_id');
    }

    /**
     * Get the category that the product belongs to.
     */
    public function category()
    {
        return $this->belongsTo('Snapshop\Models\Category','category_id');
    }
}
