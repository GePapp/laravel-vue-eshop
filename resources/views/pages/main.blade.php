<!DOCTYPE html>
<html lang="en">
  <head>
    @include('pages.partials.header')
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/styles.css">
  </head>
  <body class="body_stl">
    @include('pages.partials.nav')
    <!-- container -->
    <div class="container">
      @include('pages.partials.messages')
      @yield('content')
      @include('pages.partials.footer')
    </div>
    <!-- end container -->
    <!-- JavaScript -->
    <script src="/js/app.js"></script>
    <script src="/js/shop.js"></script>
  </body>
</html>
