@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    Utilisateurs:<br/>
                    <br/>
                    @foreach($full_users as $user)
                      {{ $user->email }}
                      @if($user->is_admin)
                      (Admin)
                      @endif
                      <br/>
                    @endforeach
                    <br/>
                    <br/>
                    Dossiers partagés:<br/>
                    <br/>
                    @foreach($folders as $folder)
                      {{ $folder->directory }} - {{ $folder->access_level }} - {{ $folder->user_id }} - <a href="{{ url('/gallery',['id' => $folder->id]) }}"> Voir la gallerie</a><br/>
                    @endforeach
                    <br/>
                    ou
                    <br/>
                    <b>Creer un nouveau dossier:</b><br/>
                    {!! Form::open(array('route' => 'folder_create', 'class' => 'form')) !!}
                    <div class="form-group">
                        {!! Form::label('Utilisateur') !!}
                        {!! Form::select('user_id', $users, null, array('required', 'class'=>'form-control') ) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Dossier') !!}
                        {!! Form::text('directory', '/', array('required', 'class'=>'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('Niveau d\'accés') !!}
                        {!! Form::select('access_level', $access, 'R', array('required','class'=>'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Creer', array('class'=>'btn btn-primary')) !!}
                    </div>
                    {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
