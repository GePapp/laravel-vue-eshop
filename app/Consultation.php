<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
  public function customer() {
    return $this->belongsTo(Customer::class);
  }

  protected $fillable = [
      'customer_id', 'amount', 'birthdate', 'birthtime', 'payment_id', 'created_at',
  ];

/** make auto timestamp insert invalid **/
  public $timestamps = false;

}
