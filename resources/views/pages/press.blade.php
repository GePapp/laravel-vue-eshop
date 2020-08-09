@extends('pages.main')
@section('title', 'Homepage')
@section('content')
    <!-- container -->
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <p class="fade-in">Presse </p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-10 offset-md-1">
      <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="/img/carousel/1.png" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/2.png" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/3.png" alt="Third slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/4.png" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/5.png" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/6.png" alt="Third slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/7.png" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/8.png" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/9.png" alt="Third slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/10.png" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/11.png" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/12.png" alt="Third slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="/img/carousel/13.png" alt="Third slide">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
@endsection
