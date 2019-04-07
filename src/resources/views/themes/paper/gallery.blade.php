@extends('layouts.paper')

@section('head')
  <title>{{ $title }}</title>
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link href="https://unpkg.com/nanogallery2/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
  <link href="https://transloadit.edgly.net/releases/uppy/v0.30.3/uppy.min.css" rel="stylesheet">
@endsection
  <script>
    function statusUpdater() {
			$.ajax({
				'url': '/api/scan/status',
			}).done(function(r) {
        console.log(r);
        $('#scan_done').html(r.done);
        $('#scan_todo').html(r.todo);
        //tant que c'est pas finis on relance
				if(r.done < r.todo) {
          setTimeout(() => {
            statusUpdater();
          }, 500);
				}
			  })
			  .fail(function() {
				  console.log( "An error has occurred... We could ask Neo about what happened, but he's taken the red pill and he's at home sleeping" );
			  });
		}

    function startScan() {
      color = 'primary';

      $.notify({
        icon: "nc-icon nc-settings-gear-65",
        message: "Scan en cours <span id='scan_done'>0</span> / <span id='scan_todo'>0</span>"

      }, {
        type: color,
        timer: 0,
        placement: {
          from: 'top',
          align: 'right'
        }
      });
      $.ajax({
        'url': '/api/scan/start'
      }).done(function(r){
        statusUpdater();
      });

    }
  </script>

@section('title')

  @if($parent)
  <a href="{{$parent}}" class="btn btn-default explore">Retour</a>&nbsp;&nbsp;&nbsp;
  @endif

  <a class="navbar-brand" href="#">{{ $title }}</a>

  &nbsp;&nbsp;&nbsp;<a class="btn btn-default explore" onclick="startScan()">Importer ce dossier</a>

@endsection

@section('content')

<div class="content">
      <div class="row">

      @if(count($directories) > 0)
      <div class="col-md-6">
        <div class="card ">
          <div class="card-header ">



            <h5 class="card-title">Sous-Dossier</h5>
            <p class="card-category"> ( {{ count($directories) }} dossiers )</p>
          </div>
          <div class="card-body ">
          @foreach ($directories as $dir)
          <i class="nc-icon nc-box"></i> <a href="{{ $dir['dirlink'] }}" >{{ $dir['basename'] }}</a><br/>
          @endforeach
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-history"></i> Updated 3 minutes ago
            </div>
          </div>
        </div>
      </div>
      @endif

      <div class="col-md-6">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Ajout de fichiers dans le dossier {{$directory}} @if($directory == "/") <i><small>(racine)</small></i> @endif</h5>
            <p class="card-category"> ( {{ count($directories) }} dossiers )</p>
          </div>
          <div class="card-body ">
          <div id="drag-drop-area"></div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-history"></i> Updated 3 minutes ago
            </div>
          </div>
        </div>
      </div>

      @if(count($files) > 0)
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Photos</h5>
            <p class="card-category">( {{ count($files) }} images )</p>
          </div>
          <div class="card-body ">
            <div data-nanogallery2>
              <?php $first = false; ?>
              @foreach ($files as $file)
                  <a href="{{ $file['img_links']['full'] }}" data-ngThumb="{{ $file['img_links']['small'] }}" data-ngdesc="{{ $file['filename'] }}"></a>
              @endforeach
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-history"></i> Updated 3 minutes ago
            </div>
          </div>
        </div>
      </div>
      @endif


  </div>
</div>
@endsection

@section('footer')
  <script type="text/javascript" src="https://unpkg.com/nanogallery2/dist/jquery.nanogallery2.min.js"></script>
  <script src="https://transloadit.edgly.net/releases/uppy/v0.30.3/uppy.min.js"></script>
  <script>
    var uppy = Uppy.Core()
      .use(Uppy.Dashboard, {
        inline: true,
        target: '#drag-drop-area'
      })
      .use(Uppy.Tus, {endpoint: 'https://master.tus.io/files/'})

    uppy.on('complete', (result) => {
      console.log('Upload complete! We’ve uploaded these files:', result.successful)
    })
  </script>
@endsection
