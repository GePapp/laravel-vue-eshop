<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
  protected $fillable = [
      'imageName', 'title', 'description', 'price',
  ];
}
