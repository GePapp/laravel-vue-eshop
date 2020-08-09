<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark">
  <a class="navbar-brand" href="#">Sundance Berlin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar2">
    <span class="navbar-toggler-icon"></span>
  </button>
    <div class="navbar-collapse collapse justify-content-between w-100" id="collapsingNavbar2">
      <ul class="navbar-nav">
        <li class="nav-item {{ Request::is('/') ? "active" : "" }} li-marg">
          <a class="nav-link" href="/">Home</a>
        </li>
        <li class="nav-item {{ Request::is('pages/karmische-astrologie') ? "active" : "" }} li-marg">
          <a class="nav-link" href="{{ route('karmische-astrologie') }}">KarmischeAstrologie</a>
        </li>
        <li class="nav-item {{ Request::is('pages/astromedizin') ? "active" : "" }} li-marg">
          <a class="nav-link" href="{{ route('astromedizin') }}">AstroMedizin</a>
        </li>
        <li class="nav-item {{ Request::is('pages/astrologische-psychologie') ? "active" : "" }} li-marg">
          <a class="nav-link" href="{{ route('astrologische-psychologie') }}">AstroPsychologie</a>
        </li>
        <li class="nav-item {{ Request::is('pages/about') ? "active" : "" }} li-marg">
          <a class="nav-link" href="{{ route('about') }}">About</a>
        </li>
        <li class="nav-item {{ Request::is('pages/contact') ? "active" : "" }} li-marg">
          <a class="nav-link" href="{{ route('contact.show') }}">Contact</a>
        </li>
        <li class="nav-item dropdown li-marg">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Topics</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Posts</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item {{ Request::is('pages/shop/index') ? "active" : "" }} li-marg">
          <a class="nav-link" href="{{ route('shop.index') }}">Shop</a>
        </li>
        <li class="nav-item {{ Request::is('pages/consultation/index') ? "active" : "" }} li-marg">
          <a class="nav-link" href="{{ route('consultation.index') }}">Online Beratung</a>
        </li>
        <li class="nav-item {{ Request::is('pages/press') ? "active" : "" }} li-marg">
          <a class="nav-link" href="{{ route('press') }}">Presse</a>
        </li>
      </ul>
  </div>
</nav>
<!-- End Navbar -->
