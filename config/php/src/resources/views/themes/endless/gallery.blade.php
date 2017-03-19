@extends('layouts.base')

@section('head')
  <title>{{ $title }}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Bootstrap core CSS -->
  <link href="http://endlesstheme.com/Endless1.5.1/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="http://endlesstheme.com/Endless1.5.1/css/font-awesome.min.css" rel="stylesheet">

  <!-- Pace -->
  <link href="http://endlesstheme.com/Endless1.5.1/css/pace.css" rel="stylesheet">

  <!-- Color box -->
  <link href="http://endlesstheme.com/Endless1.5.1/css/colorbox/colorbox.css" rel="stylesheet">

  <!-- Endless -->
  <link href="http://endlesstheme.com/Endless1.5.1/css/endless.min.css" rel="stylesheet">
  <link href="http://endlesstheme.com/Endless1.5.1/css/endless-skin.css" rel="stylesheet">
@endsection

@section('footer')
<!-- Jquery -->
<script src="http://endlesstheme.com/Endless1.5.1/js/jquery-1.10.2.min.js"></script>

<!-- Bootstrap -->
  <script src="http://endlesstheme.com/Endless1.5.1/bootstrap/js/bootstrap.min.js"></script>

<!-- Colorbox -->
<script src='http://endlesstheme.com/Endless1.5.1/js/jquery.colorbox.min.js'></script>

<!-- Modernizr -->
<script src='http://endlesstheme.com/Endless1.5.1/js/modernizr.min.js'></script>

<!-- Pace -->
<script src='http://endlesstheme.com/Endless1.5.1/js/pace.min.js'></script>

<!-- Popup Overlay -->
<script src='http://endlesstheme.com/Endless1.5.1/js/jquery.popupoverlay.min.js'></script>

<!-- Slimscroll -->
<script src='http://endlesstheme.com/Endless1.5.1/js/jquery.slimscroll.min.js'></script>

<!-- Cookie -->
<script src='http://endlesstheme.com/Endless1.5.1/js/jquery.cookie.min.js'></script>

<!-- Endless -->
<script src="http://endlesstheme.com/Endless1.5.1/js/endless/endless.js"></script>

<script>
  $(function()	{
    //Colorbox
    $('.gallery-zoom').colorbox({
      rel:'gallery',
      maxWidth:'90%',
      width:'800px'
    });
  });
</script>
@endsection

@section('content')

@if(count($files) > 0)
  <!-- Overlay Div -->
  <div id="overlay" class="transparent"></div>

  <div id="wrapper" class="preload">

    <div id="not-main-container">
      <div class="gallery-container">


            @foreach ($files as $file)
            <div class="gallery-item">
              <a class="image-wrapper gallery-zoom" style="padding-top: 56%;" href="{{ $file['img_links']['big'] }}">
                <img src="{{ $file['img_links']['small'] }}" alt="{{ $file['filename'] }}">
                <div class="image-overlay">
                  <div class="image-info">
                    <div class="h3">{{ $file['filename'] }}</div>
                    <span>{{ $file['size'] }}</span>
                    <div class="image-time">{{ $file['mtime'] }}</div>
                    <!--div class="image-like">
                      <i class="fa fa-heart"></i>
                      45 Likes
                    </div-->
                  </div>
                </div>
              </a><!-- /image-wrapper -->
            </div>
            @endforeach

      </div><!-- /gallery-container -->
    </div><!-- /main-container -->
  </div><!-- /wrapper -->
@endif

<a href="" id="scroll-to-top" class="hidden-print"><i class="fa fa-chevron-up"></i></a>

@if(count($directories) > 0)
<br/>
<br/>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <h1>{{ $title }}</h1>

                  @if($backlink)
                  <a href="{{$backlink}}" class="btn btn-default explore">Retour</a>
                  @endif
                </div>

                <div class="panel-body">
                    <strong><b>Sous-Dossier :</b></strong><br/>
                    @foreach ($directories as $dir)
                      <a href="{{ $dir['dirlink'] }}" >{{ $dir['basename'] }}</a><br/>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('footer')
  <script type="text/javascript" src="https://unpkg.com/nanogallery2/dist/jquery.nanogallery2.min.js"></script>
@endsection
