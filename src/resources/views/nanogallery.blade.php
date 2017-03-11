@extends('layouts.app')

@section('head')
  <title>{{ $title }}</title>
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link href="https://unpkg.com/nanogallery2/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
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
                  <strong>Sous-Dossier :</strong><br/>
                  @foreach ($directories as $dir)
                    <a href="{{ $dir['dirlink'] }}" >{{ $dir['basename'] }}</a><br/>
                  @endforeach

                  <strong>Photos :</strong><br/>
                  <div data-nanogallery2>
                    <?php $first = false; ?>
                    @foreach ($files as $file)
                        <a href="{{ $file['img_links']['big'] }}" data-ngThumb="{{ $file['img_links']['small'] }}" data-ngdesc="{{ $file['filename'] }}"></a>
                    @endforeach
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
  <script type="text/javascript" src="https://unpkg.com/nanogallery2/dist/jquery.nanogallery2.min.js"></script>
@endsection
