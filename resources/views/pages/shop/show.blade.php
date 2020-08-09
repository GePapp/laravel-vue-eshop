@extends('pages.main')
@section('title', 'Produkt Info')
@section('content')
  <!-- <M O D A L -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Artikel hinzugefügt</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <p id="title"></p>
          <p id="price"></p>
        </div>
      </div>
    </div>
  </div>
  <!-- Output -->
  <div class="row">
    <!-- Image -->
    <div class="col-md-4 offset-md-2">
      <img src="{{ asset('img/maps/'. $map->imageName) }}" class="img-fluid border-0 " alt="Responsive image">
    </div>

    <div class="col-md-4">
      <!-- Warenkorb - Beschreibung  -->
      <div class="card" style="width: 240px;">
        <img class="card-img-top" src="{{ asset('img/pages/cart.png') }}" alt="Card image cap">
        <div class="card-body">
          <p class="card-text">
            @if (Session::has('cart'))
              Anzahl der Artikel : {{ Session::get('cart')->totalQty }}<br>
              Gesamt Summe: {{ number_format(Session::get('cart')->totalPrice, 2) }}€
            </p>
            <a href="{{ route('shop.shoppingCart') }}" class="btn btn-custom reducefontsize">Korb Anzeigen</a>
          @else
            Keine Waren im Korb
          @endif
        </div>
      </div>
      <br>
      <!-- Price - Add  -->
      <div>Preis: {{ number_format($map->price, 2) }}€</div>
      <div>
        <a href="{{ url('shop/addToCart', ['id' => $map->id]) }}" class="btn btn-add btn-custom reducefontsize"
          data-toggle="modal" data-target="#myModal"  data-id="{{ $map->id }}"
          data-price="{{ $map->price }}" data-title="{{ $map->title }}" data-img="{{ $map->imageName }}"  role="button">Add</a>
        </div>
      </div>
    </div>
    <br>
    <!-- Title- Description  -->
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <p class="p_title">{{ $map->title }}</p>
        <p>{!! $map->description !!}</p>
      </div>
    </div>
@endsection
@section('scripts')
  <script type="text/javascript" src="{{ asset('js/shop.js') }}"></script>
@endsection
