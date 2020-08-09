@extends('pages.main')
@section('title', 'Shopping Cart')
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
<!-- MSG----->
@if(Session::has('success'))
<div class="row">
    <div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
        <div id="charge-message" class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    </div>
</div>
@endif
<!-- T I T L E ----->
<div class="row">
    <div class="col-md-12">
        <p class="fade-in">Shopping Cart</p>
    </div>
</div>
<hr>
<!-- S H O P ----->
<div class="row">
    <div class="col-md-8">
        @foreach($maps->chunk(2) as $mapChunk)
            <div class="row">
                @foreach($mapChunk as $map)
                <div class=" col-md-5 md-offset-1">
                    <a href="{{ route('shop.show', ['id' => $map->id]) }}">
                        <figure class="figure">
                            <img src="{{ asset('img/maps/'. $map->imageName) }}" alt="" class="img-fluid border-0 mx-auto d-block zoom" style="width: 150px; height: 250px;">
                            <figcaption class="figure-caption text-center shop_ttl" style="margin-top: 10px;">{{ $map->title }}</figcaption>
                        </figure>
                    </a>
                    <hr>
                    <div class="pull-left shop_ttl">Preis: {{ $map->price }}€
                        <a href="{{ route('shop.addToCart', ['id' => $map->id]) }}" class="btn btn-custom reducefontsize btn-add float-right" data-toggle="modal" data-target="#myModal" data-id="{{ $map->id }}" data-price="{{ $map->price }}"
                          data-title="{{ $map->title }}" data-img="{{ $map->imageName }}" role="button">Add</a>
                    </div>
                </div>
                @endforeach
            </div>
            <br>
            @endforeach
            <!--   P A G I N A T I O N    -->
            <br>
            <div class="col-md-12">
                <nav class="nav_lks">
                    <ul class="pagination pagination-md justify-content-center">
                        {{ $maps->links() }}
                    </ul>
                </nav>
            </div>
    </div>
    <!-- Warenkorb - Beschreibung  -->
    <div class="col-md-4">
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
        <p class="shop_ttl">Astrologische Stadtpläne & Karten</p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.<br>
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.<br>
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br>
            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
            totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.<br>
            Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
            eos qui ratione voluptatem sequi nesciunt.<br>
            Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit,
            sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
        </p>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/shop.js') }}"></script>
@endsection
