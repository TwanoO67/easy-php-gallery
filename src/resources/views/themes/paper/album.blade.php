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

      @if(count($album->files) > 0)
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">album->files</h5>
            <p class="card-category">( {{ count($album->files) }} images )</p>
          </div>
          <div class="card-body ">
            <div data-nanogallery2>
              <?php $first = false; ?>
              @foreach ($album->files as $file)
                  <a href="{{ $file['img_links']['full'] }}" data-ngThumb="{{ $file['img_links']['small'] }}" data-ngdesc="{{ $file['path'] }}"></a>
              @endforeach
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-history"></i> Updated at {{ $album->updated_at }}
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
