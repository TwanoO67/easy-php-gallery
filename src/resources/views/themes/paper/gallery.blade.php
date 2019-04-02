@extends('layouts.paper')

@section('head')
  <title>{{ $title }}</title>
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link href="https://unpkg.com/nanogallery2/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
@endsection

@section('title')
  <a class="navbar-brand" href="#">{{ $title }}</a>

  @if($backlink)
  <a href="{{$backlink}}" class="btn btn-default explore">Retour</a>
  @endif

@endsection

@section('content')

<div class="content">
      <div class="row">

      @if(count($directories) > 0)
      <div class="col-md-12">
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
                  <a href="{{ $file['img_links']['big'] }}" data-ngThumb="{{ $file['img_links']['small'] }}" data-ngdesc="{{ $file['filename'] }}"></a>
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
@endsection
