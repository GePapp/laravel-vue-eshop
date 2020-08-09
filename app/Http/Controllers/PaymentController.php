<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use App\Cart;
use App\Order;
use App\Customer;
use App\Consultation;
use Mail;
/** use Carbon for manual insert timestamp Date **/
use Carbon\Carbon;

class PaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function index()
    {
        return view('paywithpaypal');
    }



    public function payWithpaypal(Request $request) {



        /** -------------- Validation ---------------------- **/
        if($request->get('consultation')) {
          $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required',
            'birthdate' => 'required',
            'birthtime' => 'required',
            'amount' => 'required',
          ]);
        }else{
          $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'postcode' => 'required',
            'street' => 'required',
            'country' => 'required',
          ]);
        }


        /** -------------- Counceling Payment ---------------------- **/
        if($request->get('consultation')) {

          $payer = new Payer();
          $payer->setPaymentMethod('paypal');

          $item1 = new Item();

          $item1->setName('Item 1') /** item name **/
              ->setCurrency('EUR')
              ->setQuantity(1)
              ->setPrice($request->get('amount')); /** unit price **/

          $item_list = new ItemList();
          $item_list->setItems(array($item1));

          $amount = new Amount();
          $amount->setCurrency('EUR')
              ->setTotal($request->get('amount'));

          $transaction = new Transaction();
          $transaction->setAmount($amount)
              ->setItemList($item_list)
              ->setDescription('Your transaction description');

          $redirect_urls = new RedirectUrls();
          $redirect_urls->setReturnUrl(URL::to('status')) /** Specify return URL **/
              ->setCancelUrl(URL::to('status'));

          $payment = new Payment();
          $payment->setIntent('Sale')
              ->setPayer($payer)
              ->setRedirectUrls($redirect_urls)
              ->setTransactions(array($transaction));

          /** dd($payment->create($this->_api_context));exit; **/
          try {
              $payment->create($this->_api_context);
          } catch (\PayPal\Exception\PPConnectionException $ex) {
              if (\Config::get('app.debug')) {
                  \Session::put('error', 'Connection timeout');
                  return Redirect::to('/');
              } else {
                  \Session::put('error', 'Some error occur, sorry for inconvenient');
                  return Redirect::to('/');
              }
          }

          foreach ($payment->getLinks() as $link) {

              if ($link->getRel() == 'approval_url') {
                  $redirect_url = $link->getHref();
                  break;
              }
          }

          /** put Request Data into Session **/
          Session::put('name', $request->input('name'));
          Session::put('email', $request->input('email'));
          Session::put('phone', $request->input('phone'));
          Session::put('birthdate', $request->input('birthdate'));
          Session::put('birthtime', $request->input('birthtime'));
          Session::put('amount', $request->input('amount'));
          Session::put('consultation', $request->input('consultation'));

          /** add payment ID to session **/
          Session::put('paypal_payment_id', $payment->getId());

          if (isset($redirect_url)) {
              /** redirect to paypal **/
              return Redirect::away($redirect_url);
          }

          \Session::put('error', 'Unknown error occurred');
          return Redirect::to('/');
        }

          /** -------------- Shopping Cart Payment ---------------------- **/
        else {
          $payer = new Payer();
          $payer->setPaymentMethod('paypal');

          if (!Session::has('cart')) {
              return redirect()->route('product.shoppingCart');
          }
          $oldCart = Session::get('cart');
          $cart = new Cart($oldCart);

          $items = array();
          $subtotal = 0;

          foreach($cart->items  as $products) {
            $item = new Item();
            $item->setName($products['item']['title'])
              ->setCurrency('EUR')
              ->setQuantity($products['qty'])
              ->setPrice($products['item']['price']);
            $items[] = $item;
            // $subtotal += $products['qty'] * $products['item']['price'];
          }

          $item_list = new ItemList();
          $item_list->setItems($items);

          // print_r ($item_list);
          // exit;

          $amount = new Amount();
          $amount->setCurrency('EUR')
              ->setTotal($request->get('amount'));
              // ->setTotal($subtotal);

          $transaction = new Transaction();
          $transaction->setAmount($amount)
              ->setItemList($item_list)
              ->setDescription('Your transaction description');

          $redirect_urls = new RedirectUrls();
          $redirect_urls->setReturnUrl(URL::to('status')) /** Specify return URL **/
              ->setCancelUrl(URL::to('status'));

          $payment = new Payment();
          $payment->setIntent('Sale')
              ->setPayer($payer)
              ->setRedirectUrls($redirect_urls)
              ->setTransactions(array($transaction));
          /** dd($payment->create($this->_api_context));exit; **/


          try {
              $payment->create($this->_api_context);
          } catch (\PayPal\Exception\PPConnectionException $ex) {
              if (\Config::get('app.debug')) {
                  \Session::put('error', 'Connection timeout');
                  return Redirect::to('/');
              } else {
                  \Session::put('error', 'Some error occur, sorry for inconvenient');
                  return Redirect::to('/');
              }
          }

          foreach ($payment->getLinks() as $link) {
              if ($link->getRel() == 'approval_url') {
                  $redirect_url = $link->getHref();
                  break;
              }
          }

          /** put Request Data into Session **/
          Session::put('cart', $cart);
          Session::put('name', $request->input('name'));
          Session::put('email', $request->input('email'));
          Session::put('postcode', $request->input('postcode'));
          Session::put('street', $request->input('street'));
          Session::put('country', $request->input('country'));
          Session::put('phone', $request->input('phone'));

          /** add payment ID to session **/
          Session::put('paypal_payment_id', $payment->getId());

          if (isset($redirect_url)) {
              /** redirect to paypal **/
              return Redirect::away($redirect_url);
          }

          \Session::put('error', 'Unknown error occurred');
          return Redirect::to('/');
        }

    }

    public function getPaymentStatus()
    {
      /** -------------- Consultation Payment ---------------------- **/
      if (Session::get('consultation') ) {

        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** Get Request Data before session clear **/

        $name = Session::get('name');
        $email = Session::get('email');
        $phone = Session::get('phone');
        $birthdate = Session::get('birthdate');
        $birthtime = Session::get('birthtime');
        $amount = Session::get('amount');

        /** clear the session payment ID and counceling **/
        Session::forget('consultation');
        Session::forget('paypal_payment_id');
        /** Session::flush(); **/
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            \Session::flash('error', 'Payment failed');
            return Redirect::to('/');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {


          /** store Consultations **/

          $customer = Customer::where('email','=', $email)->first();

          if($customer) {
            /*  phone update if new phone-number */
            if ($customer->phone !== $phone){
              $customer->phone = $phone;
              $customer->save();
            }
            /*  insert birthdate if no one */
            if (!$customer->birthdate){
              $customer->birthdate = $birthdate;
              $customer->save();
            }
              /*  insert birthtime if no one */
            if (!$customer->birthtime){
              $customer->birthtime = $birthtime;
              $customer->save();
            }

            $consultation = new Consultation();
            $consultation->customer_id = $customer->id;
            $consultation->amount = $amount;
            $consultation->payment_id = $payment->getId();
            $consultation->created_at = Carbon::now();
            $consultation->save();
          }
        else {
          $customer = new Customer();
          $customer->name = $name;
          $customer->email = $email;
          $customer->phone = $phone;
          $customer->birthdate = $birthdate;
          $customer->birthtime = $birthtime;
          $customer->save();
          $customer = Customer::where('email','=', $email)->first();
          $consultation = new Consultation();
          $consultation->customer_id = $customer->id;
          $consultation->amount = $amount;
          $consultation->payment_id = $payment->getId();
          $consultation->created_at = Carbon::now();
          $consultation->save();
        }
        /** End store Orders **/

          /** Send mail to Customer **/
          $data = array(
            'email' => $email,
            'subject' => 'Ihre Überweisung zu Online Beratung bei Sundance Berlin',
            'bodyMessage' => 'Ihre Überweisung ist bei uns eingegangen. Vielen Dank.'
            );
          Mail::send('emails.counceling_customer', $data, function($message) use($data) {
            $message->from('ufaethon@gmail.com');
            $message->to($data['email']);
            $message->subject($data['subject']);
          });

          /** Send mail to Sundance **/
          $bodyMessage = 'Neue Online Beratungs Überweisung via PayPal, von '. $name. ', tel: '. $phone;
          $data = array(
            'email' => $email,
            'subject' => 'Neue Online Beratungs Überweisung via PayPal',
            'bodyMessage' => $bodyMessage
            );
          Mail::send('emails.counceling', $data, function($message) use($data) {
            $message->from($data['email']);
            $message->to('ufaethon@gmail.com');
            $message->subject($data['subject']);
          });

          /** flash Message **/
          \Session::flash('success', 'Überweisung erfolgreich');
            return Redirect::to('/');
        }
        \Session::flash('error', 'Überweisung erfolglos');
        // \Session::put('error', 'Payment failed');
        return Redirect::to('/');

      }

      /** -------------- Shopping Cart Payment ---------------------- **/
    else {
      /** Get the payment ID before session clear **/
      $payment_id = Session::get('paypal_payment_id');

      /** Get Request Data before session clear **/
      $cart = Session::get('cart');
      $name = Session::get('name');
      $email = Session::get('email');
      $postcode = Session::get('postcode');
      $street = Session::get('street');
      $country = Session::get('country');
      $phone = Session::get('phone');

      /** clear the session payment ID and cart **/
      Session::forget('cart');
      Session::forget('paypal_payment_id');

      if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

          \Session::flash('error', 'Payment failed');
          return Redirect::to('/');

      }

      $payment = Payment::get($payment_id, $this->_api_context);
      $execution = new PaymentExecution();
      $execution->setPayerId(Input::get('PayerID'));

      /**Execute the payment **/
      $result = $payment->execute($execution, $this->_api_context);

      if ($result->getState() == 'approved') {

        /** store Orders **/

        $customer = Customer::where('email','=', $email)->first();

        if($customer) {

          if ($customer->phone !== $phone){
            $customer->phone = $phone;
            $customer->save();
          }
          
          $order = new Order();
          $order->customer_id = $customer->id;
          $order->postcode = $postcode;
          $order->street = $street;
          $order->country = $country;
          $order->cart = serialize($cart);
          $order->payment_id = $payment_id;
          $order->created_at = Carbon::now();
          $order->save();
        }
      else {
        $customer = new Customer();
        $customer->name = $name;
        $customer->email = $email;
        $customer->phone = $phone;
        $customer->save();
        $customer = Customer::where('email','=', $email)->first();
        $order = new Order();
        $order->customer_id = $customer->id;
        $order->postcode = $postcode;
        $order->street = $street;
        $order->country = $country;
        $order->cart = serialize($cart);
        $order->payment_id = $payment_id;
        $order->created_at = Carbon::now();
        $order->save();
      }
      /** End store Orders **/

      /** Send mail to Customer **/
      $data = array(
        'email' => $email,
        'subject' => 'Ihre Bestellung bei Sundance Berlin',
        'bodyMessage' => 'Ihre Bestellung ist bei uns eingegangen. Wir werden die Waren unmittelbar versenden. Vielen Dank.'
        );
      Mail::send('emails.shop_customer', $data, function($message) use($data) {
        $message->from('ufaethon@gmail.com');
        $message->to($data['email']);
        $message->subject($data['subject']);
      });

      /** Send mail to Sundance **/
      $bodyMessage = 'Neue Bestellung via PayPal, von '. $name;
      $data = array(
        'email' => $email,
        'subject' => 'Neue Bestellung via PayPal',
        'bodyMessage' => $bodyMessage
        );
      Mail::send('emails.shop', $data, function($message) use($data) {
        $message->from($data['email']);
        $message->to('ufaethon@gmail.com');
        $message->subject($data['subject']);
      });

      /** flash Message **/
      \Session::flash('success', 'Überweisung erfolgreich');
    //  \Session::put('success', 'Payment success');
      return Redirect::to('/');
      }

      \Session::flash('error', 'Überweisung erfolglos');
  //  \Session::put('error', 'Überweisung erfolglos');
    return Redirect::to('/');
    }
  }
}
