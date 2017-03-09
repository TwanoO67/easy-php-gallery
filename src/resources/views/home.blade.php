@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  @if($user->is_admin)
                    <a href="{{ url('/folders') }}"> Editer les dossier</a>
                  @endif
                  <br/>
                  Vos dossiers partagés:<br/>
                  <br/>
                  @forelse ($folders as $folder)
                      {{ $folder->directory }} - {{ $folder->access_level }} - <a href="{{ url('/gallery',['id' => $folder->id]) }}"> Voir la gallerie</a><br/>
                  @empty
                      <p>Aucun dossier configuré</p>
                  @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
