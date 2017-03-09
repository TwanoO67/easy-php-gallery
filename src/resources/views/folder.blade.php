@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Your folders:

                    @foreach($folders as $folder)
                      { $folder->disk } - { $folder->directory } - { $folder->acces_level }
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
