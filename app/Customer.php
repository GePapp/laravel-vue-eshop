<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  public function orders() {
      return $this->hasMany(Order::class);
  }
  public function consultations() {
      return $this->hasMany(Consultation::class);
  }

  protected $fillable = [
      'name', 'email', 'postcode', 'street', 'country', 'phone', 'created_at',
  ];

  /** make auto timestamp insert invalid **/
    public $timestamps = false;
}
