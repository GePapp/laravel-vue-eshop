<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultationController extends Controller
{

  public function getIndex() {
      return View('pages.consultation.index');
  }

}
