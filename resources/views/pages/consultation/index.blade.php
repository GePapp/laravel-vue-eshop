@extends('pages.main')
@section('title', 'Online Beratung')
@section('content')
  <div class="row">
    <div class="col-md-8">
      <p class="fade-in">Online Beratung</p>
      <p>
        Sie wollen eine Ortsanalyse gerne persönlich besprechen? <br>
        Noch individueller und präziser als jeder online Service ist nun mal ein persönliches Beratungsgespräch. <br>
        Nutzen Sie die Möglichkeit zu einer Sofortberatung um schnelle Entscheidungen zu treffen. <br>
        Wenn es um besonders wichtige Entscheidungen wie zum Beispiel Grundstückskauf geht, <br>
        oder wenn Sie sich einfach nicht sicher sind was das Richtige für sie ist. Ich biete Ihnen eindeutige Empfehlungen an.
      </p>
      <p>
        Mit Georg Stockhorst dem Entwickler der Astrologischen Weltkarte. Wochentags zwischen 10:00 und 18:30. <br>
        Über Festnetz (keine kostenpflichtige Hotline!). <br>
        Bezahlung per Sofortüberweisung über Paypal Plus –  geht auch per Kreditkarte.
      </p>
      <p>

      </p>Ich analysiere Adressen und Städte für Sie per Sofortberatung.  <br>
        Das Gespräch geht nicht über eine kostenpflichtige Hotline sondern über Festnetz, Skype oder facebook phone. <br>
        Die Bezahlung machen Sie per Sofortüberweisung über Paypal oder Kreditkarte. <br>
        Senden Sie einfach eine email an astrogeography@email.de oder rufen Sie mich auf dem Festnetz an unter 030 3451233. <br>
        Wählen Sie aus wie lang Ihr Beratungstermin sein soll: <br>
        <strong>15 min. 35 €</strong> <br>
        <strong>60 min. 100 €</strong> <br>
        <strong>Terminvereinbarung: 0049 (0)30 3451233  (Festnetz)</strong> <br>
        Wir vereinbaren einen Termin am selben oder nächsten Tag. <br>
        Nach der Terminvereinbarung erhalten sie per email eine Rechnung für die Sofort Überweisung <br>
        Keine Hotline!!! <br>
        Bezahlung per Paypal Plus
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-header text-center">Online Beratung</div>
        <div class="card-body">
          <form method="POST" id="payment-form" action="{!! URL::to('paypal') !!}" data-parsley-validate>

            <div class="form-group">
              <label for="name">Name</label>
              <div>
                <input id="name" type="text" class="form-control reducefontsize" name="name" required maxlength="100">
              </div>
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <div>
                <input id="email" type="text" class="form-control reducefontsize" name="email" required data-parsley-type="email">
              </div>
            </div>
            <div class="form-group">
              <label for="phone">Telefon</label>
              <div>
                <input id="phone" type="text" class="form-control reducefontsize" name="phone" required>
              </div>
            </div>

            <div class="form-group">
              <label for="birthdate">Geburtstag</label>
              <div>
                <input id="birthdate" type="text" class="form-control reducefontsize" name="birthdate" placeholder="Beispiel: 03.08.1998" required>
              </div>
            </div>
            <div class="form-group">
              <label for="birthtime">Geburtszeit</label>
              <div>
                <input id="birthtime" type="text" class="form-control reducefontsize" name="birthtime" placeholder="Beispiel: 17:35" required>
              </div>
            </div>

            <div class="form-group">
              <label for="amount">Betrag</label>
              <div>
                <input id="amount" type="text" class="form-control reducefontsize" name="amount" required data-parsley-type="number" maxlength="6">
              </div>
            </div>

            <div class="form-group">
              <input type="hidden" class="form-control" id="consultation" name="consultation" value="ok">
              <button type="submit" class="btn btn-custom reducefontsize" style="width: 160px;">Überweisen</button>
              {{ csrf_field() }}
              </button>
            </div>
          </form>
        </div>
        <div class="card-footer d-flex justify-content-end">
          <img src="{{url('/img/pages/paypal_logo.png')}}" alt="PayPal Logo">
        </div>
      </div>
    </div>
  </div>
@endsection
