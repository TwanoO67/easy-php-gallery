@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Vos dossiers partagés:<br/>
                    <br/>
                    @foreach($folders as $folder)
                      {{ $folder->disk }} - {{ $folder->directory }} - {{ $folder->access_level }} - {{ $folder->user_id }} <br/>
                    @endforeach
                    <br/>
                    ou
                    <br/>
                    <b>Creer un nouveau dossier:</b><br/>
                    {!! Form::open(array('route' => 'folder_create', 'class' => 'form')) !!}

                    <div class="form-group">
                        {!! Form::label('User_id') !!}
                        {!! Form::select('user_id', $users, array('required', 'class'=>'form-control', 'placeholder'=>'User')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Disk') !!}
                        {!! Form::select('disk', $disks,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'Disk')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Dossier') !!}
                        {!! Form::text('directory', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'Dossier')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Acces level') !!}
                        {!! Form::select('access_level', $access,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'Access level')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::submit('Creer',
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                    {!! Form::close() !!}


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
