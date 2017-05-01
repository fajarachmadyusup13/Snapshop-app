<?php

namespace Snapshop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'transaction_date',
        'user_id',
        'total_amount',
        'status',
    ];

    public function orders()
    {
        return $this->hasMany('Snapshop\Models\Order');
    }

    public function user()
    {
        return $this->belongsTo('Snapshop\Models\User','user_id');
    }
}
