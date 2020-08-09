<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Consultation;

class ConsultationController extends Controller
{
  /* Create api auth. */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $consultations = Consultation::with('customer')->orderBy('created_at', 'DESC')->paginate(2);
        return $consultations;
    }

    public function search(){
      // if condition to check that search input is't empty and the axios request has a q variable
        if ($search = \Request::get('q')) {
          $consultations = Consultation::whereHas('customer', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%$search%");
          })->with('customer')->orderBy('created_at', 'desc')->paginate(2);
        }else{
            $consultations = Consultation::with('customer')->orderBy('created_at', 'desc')->paginate(2);
        }
        return $consultations;
    }

    public function setChecked($id){
      $consultation = Consultation::findOrFail($id);
      $consultation->unchecked = false;
      $consultation->save();
    }

    public function selectUnChecked(){
      $consultations = Consultation::whereHas('customer', function ($query) {
        $query->where('unchecked', 1);
        })->with('customer')->orderBy('created_at', 'DESC')->paginate(2);
        return $consultations;
    }

    public function printConsultation($id) {
      /*$order = Consultation::find($id)->with('customer');*/
      $consultation = Consultation::whereHas('customer', function ($query) use ($id) {
        $query->where('consultations.id', $id);
      })->with('customer')->get();
        return $consultation;
    }

}
