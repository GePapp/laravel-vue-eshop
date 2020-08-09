@extends('pages.main')
@section('title', 'Shopping Cart')
@section('content')
  @if(Session::has('cart'))
    <div class="row">
      <div class="col-md-6 md-offset-3 mx-auto">
        <div class="card">
            <div class="card-header text-center">Ihre Bestellung</div>
            <div class="card-body">
              <ul class="list-group">
                @foreach($maps as $map)
                  <li class="list-group-item">
                    <div>
                      {{ $map['item']['title'] }}, Anzahl: {{ $map['qty'] }}<br>
                      Preis: {{ number_format($map['price'], 2) }}€
                    </div>
                    <span class="dropdown">
                      <button class="btn btn-custom reducefontsize dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ändern
                      </button>
                      <div class="dropdown-menu reducefontsize" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('shop.reduceByOne', ['id' => $map['item']['id']]) }}">subtrahieren</a>
                        <a class="dropdown-item" href="{{ route('shop.remove', ['id' => $map['item']['id']]) }}">löschen</a>
                      </div>
                    </span>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
          <br>
          <div class="col-md-12 mx-auto">
            Gesamt Summe: {{ number_format($totalPrice, 2) }}€</strong>
          </div>
        </div>
      <div class="col-md-6 md-offset-3 mx-auto">
        <div class="card">
          <div class="card-header text-center">Versanddaten</div>
          <div class="card-body">
            <!--FORM DATA-->
            <form method="POST" id="payment-form" action="{!! URL::to('paypal') !!}" data-parsley-validate>

              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control reducefontsize" name="name" required maxlength="100">
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                <div class="col-md-6">
                  <input id="email" type="text" class="form-control reducefontsize" name="email" required data-parsley-type="email">
                </div>
              </div>

              <div class="form-group row">
                <label for="postcode" class="col-md-4 col-form-label text-md-right">PLZ Stadt</label>
                <div class="col-md-6">
                  <input id="postcode" type="text" class="form-control reducefontsize" name="postcode" required>
                </div>
              </div>

              <div class="form-group row">
                <label for="street" class="col-md-4 col-form-label text-md-right">Straße</label>
                <div class="col-md-6">
                  <input id="street" type="text" class="form-control reducefontsize" name="street" required>
                </div>
              </div>

              <div class="form-group row">
                <label for="country" class="col-md-4 col-form-label text-md-right">Land</label>
                <div class="col-md-6">
                  <input id="country" type="text" class="form-control reducefontsize" name="country" required>
                </div>
              </div>

              <div class="form-group row">
                <label for="phone" class="col-md-4 col-form-label text-md-right">Telefon</label>
                <div class="col-md-6">
                  <input id="phone" type="text" class="form-control reducefontsize" name="phone" data-parsley-type="number">
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <input type="hidden" class="form-control" id="amount" name="amount" value="{{ $totalPrice }}">
                  <button type="submit" class="btn btn-custom reducefontsize" style="width: 160px;">Bestellen</button>
                  {{ csrf_field() }}
                  </button>
                </div>
              </div>

            </form>
          </div>
          <div class="card-footer d-flex justify-content-end">
            <img src="{{url('/img/pages/paypal_logo.png')}}" alt="PayPal Logo">
          </div>

        </div>
      </div>
    </div>
  @else
    <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
      <h4>No Items in Cart</h4>
    </div>
  @endif
@endsection
