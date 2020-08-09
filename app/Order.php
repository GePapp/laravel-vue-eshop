<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  public function customer() {
    return $this->belongsTo(Customer::class);
  }

  protected $fillable = [
      'customer_id', 'cart', 'payment_id', 'done', 'created_at',
  ];

/** make auto timestamp insert invalid **/
  public $timestamps = false;

  /** define accessor to unserialize cart column value ---> laravel Accessors **/
  public function getCartAttribute($value) {
   return unserialize($value);
  }
}
