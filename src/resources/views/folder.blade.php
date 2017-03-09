@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Your folders:

                    {!! Form::open(array('route' => 'folder_create', 'class' => 'form')) !!}

                    <div class="form-group">
                        {!! Form::label('User_id') !!}
                        {!! Form::text('user_id', null,
                            array('required',
                                  'class'=>'form-control',
                                  'placeholder'=>'User')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('Disk') !!}
                        {!! Form::text('disk', null,
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
                        {!! Form::submit('Creer',
                          array('class'=>'btn btn-primary')) !!}
                    </div>
                    {!! Form::close() !!}

                    @foreach($folders as $folder)
                      { $folder->disk } - { $folder->directory } - { $folder->acces_level }
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
