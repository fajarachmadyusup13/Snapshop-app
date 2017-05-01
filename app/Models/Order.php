<?php

namespace Snapshop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'sub_total',
    ];


    public function product()
    {
        return $this->belongsTo('Snapshop\Models\Product','product_id');
    }

    public function cart()
    {
        return $this->belongsTo('Snapshop\Models\Cart','cart_id');
    }
}
