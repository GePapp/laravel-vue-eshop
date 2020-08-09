@extends('pages.main')
@section('title', 'Kontakt')
@section('stylesheets')
  <link rel="stylesheet" href="{{ URL::asset('css/parsley.css') }}">
@endsection
@section('content')
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-header text-center">Nachricht Senden</div>

        <div class="card-body">
          <form method="POST" action="{{ route('contact') }}" data-parsley-validate>

            <div class="form-group">
              <label for="email">Email</label>
              <div>
                <input id="email" type="email" class="form-control reducefontsize" name="email" required autofocus data-parsley-type="email">
              </div>
            </div>

            <div class="form-group">
              <label for="subject">Subject</label>
              <div>
                <input id="subject" type="text" class="form-control reducefontsize" name="subject" required>
              </div>
            </div>

            <div class="form-group">
              <label for="message">Nachricht</label>
              <div>
                <textarea id="message" class="form-control reducefontsize" name="message" rows="6" required></textarea>
              </div>
            </div>

            <div class="form-group">
              <div>
                <button type="submit" class="btn btn-custom reducefontsize">Senden</button>
                {{ csrf_field() }}
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script type="text/javascript" src="{!! asset('js/parsley.min.js') !!}"></script>
@endsection
