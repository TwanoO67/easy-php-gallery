@extends('layouts.paper')

@section('head')
  <title>{{ $title }}</title>
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>
   <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
   integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
   crossorigin=""></script>
@endsection

@section('title')

  <a class="navbar-brand" href="#">{{ $title }}</a>

@endsection

@section('content')

<div class="content">
      <div class="row">

      <div class="col-md-12">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Carte</h5>
          </div>
          <div class="card-body ">
             <div id="mapid"></div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-history"></i> Updated 3 minutes ago
            </div>
          </div>
        </div>
      </div>


  </div>
</div>
@endsection

@section('footer')
<script>

function maCarte(position) {
    var h = document.documentElement.clientHeight - 350;
    $('#mapid').height(h);

    var mymap = L.map('mapid').setView([position.coords.latitude, position.coords.longitude], 13);
    var token = "pk.eyJ1IjoidHdhbm9vNjciLCJhIjoiY2p1d2w2b3F0MDBsMjRkcGd2OG80bTkxaCJ9.uWI1qocktF1b4waHgQR-UA";

    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: '2019 © EasyPhpGallery',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: token
    }).addTo(mymap);

    var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(mymap);
    marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
}

if(navigator.geolocation){
  navigator.geolocation.getCurrentPosition(maCarte);
} else {
  maCarte({
      coords: {
          latitude: 51.5,
          longitude: -0.09
      }
  });
}

</script>
@endsection
