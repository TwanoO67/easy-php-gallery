@extends('layouts.paper')

@section('head')
  <title>{{ $title }}</title>
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link href="https://unpkg.com/nanogallery2/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
  @endsection

@section('title')

  <a href="{{ route('albums') }}" class="btn btn-default explore">Liste des albums</a>&nbsp;&nbsp;&nbsp;

  <a class="navbar-brand" href="#">{{ $title }}</a>

@endsection

@section('content')

<div class="content">

    <div class="row">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-body">
            <button class="btn btn-danger btn-sm" id='btn_delete' onclick="deleteAlbum()">
              <i class="fas fa-trash"></i> Supprimer
            </button>
          </div>
        </div>
      </div>
    </div>


      <div class="row">


      <div class="col-md-12">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Photos</h5>
            <p class="card-category">( {{ count($album->photos) }} images )</p>
          </div>
          <div class="card-body ">
            @if(count($album->photos) > 0)
            <div data-nanogallery2>
              <?php $first = false; ?>
              @foreach ($album->photos as $file)
                  <a href="{{ $file->img_links['full'] }}" data-ngThumb="{{ $file->img_links['small'] }}" data-ngdesc="{{ $file->basename }}"></a>
              @endforeach
            </div>
            @endif
            @if(count($album->photos) === 0)
                <span>Cette album ne contient pas encore de photo. Aller dans vos <a href="{{route('gallery')}}">fichiers</a> pour en ajouter.</span>
            @endif
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-history"></i> Updated at {{ $album->updated_at }}
            </div>
          </div>
        </div>
      </div>



  </div>
</div>
@endsection

@section('footer')
  <script type="text/javascript" src="https://unpkg.com/nanogallery2/dist/jquery.nanogallery2.min.js"></script>
  <script>
    function deleteApi(myJSObject){
      var url = "{{ route('album_delete') }}";
        $.ajax(url, {
          data : JSON.stringify(myJSObject),
          contentType : 'application/json',
          type : 'POST'
        }).done(function( data ) {
          window.location = "{{route('albums')}}";
        }).fail(function(error) {
            console.log(error);
            $.notify({
                icon: "nc-icon nc-settings-gear-65",
                message: "error.message"
            }, {
                type: "error",
                timer: 5,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
        });
    }

    function deleteAlbum(){
      if( confirm( "Etes vous sur de vouloir supprimer l\'album courant ?" ) ){
        var myJSObject = {
          'id': "{{$album->id}}"
        }
        deleteApi(myJSObject);

      }
    }

  </script>
@endsection
