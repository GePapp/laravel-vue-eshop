<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Session;

class PageController extends Controller
{
  public function getIndex()
  {
    return view('welcome');
  }
  /** Karmische Astrologie Page **/
  public function getKarmischeAstrologie()
  {
    return view('pages.karmische-astrologie');
  }
  /** Astrologische Psychologie Page **/
  public function getAstrologischePsychologie()
  {
    return view('pages.astrologische-psychologie');
  }
  /** AstroMedizin Page **/
  public function getAstroMedizin()
  {
    return view('pages.astromedizin');
  }
  public function getAbout()
  {
    return view('pages.about');
  }
  /** Presse Page **/
  public function getPress()
  {
    return view('pages.press');
  }
  /** Contact Page **/
  public function getContact() {
    return view('pages.contact');
  }
  public function postContact(Request $request) {
    $this->validate($request, array(
      'email' => 'required|email',
      'subject' => 'required',
      'message' => 'required'
      ));
    $data = array(
      'email' => $request->email,
      'subject' => $request->subject,
      'bodyMessage' => $request->message
      );
    Mail::send('emails.contact', $data, function($message) use($data) {
      $message->from($data['email']);
      $message->to('ufaethon@gmail.com');
      $message->subject($data['subject']);
          // $message->cc();
          // $message->reply_to();
    });
    Session::flash('success', 'Your Enail was sent');
    return view('pages.contact');
  }

}
