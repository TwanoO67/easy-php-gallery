@extends('layouts.paper')

@section('head')
  <title>{{ $title }}</title>
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
  <script>
    function goto(url){
        window.location = url;
    }
  </script>
@endsection

@section('title')

  <a href="/" class="btn btn-default explore">Retour</a>&nbsp;&nbsp;&nbsp;

  <a class="navbar-brand" href="#">{{ $title }}</a>

@endsection

@section('content')

<div class="content">

    <div class="row">
      <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">Albums</h4>
                </div>
                <div class="card-content">
                    @foreach ($albums as $album)
                        <button class="btn btn-default btn-fill btn-wd" onclick="goto('{{ route('album', ['id' => $album->id]) }}')">{{$album->name}}</button>
                    @endforeach
                    @if(count($albums) === 0)
                        <span>Pas d'album encore disponible. Il faut attendre un import ?</span>
                    @endif

                </div>

            </div>
        </div>
    </div>

</div>
@endsection


@section('footer')
  <script>

    function create() {
      var name = prompt('Quel nom pour votre album ?');
      var url = "{{ route('album_create') }}";
      var myJSObject = {
        'name': name,
        'access_level': 'R',
      }
      $.ajax(url, {
        data : JSON.stringify(myJSObject),
        contentType : 'application/json',
        type : 'POST'
      }).done(function( data ) {
        window.location.reload();
      })

    }
    </script>
@endsection