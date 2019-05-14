@extends('layouts.paper')

@section('head')
  <title>{{ $title }}</title>
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link href="https://unpkg.com/nanogallery2/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
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
            <h5 class="card-title">EasyPhpGallery</h5>
            <p class="card-category">Votre gestionnaire de photos</p>
          </div>
          <div class="card-body ">
            <b>EasyPhpGallery</b> est là pour vous aider à partager facilement vos photos avec vos amis. <br/>
            Vous pouvez aussi retrouver facilement vos photos grace à nos tags et cartes.<br/>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <i class="fa fa-history"></i> Projet Open-Source sur GitHub
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
