@extends('layouts.paper')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h5>Administration</h5></div>

                <div class="panel-body">

                    <strong>Utilisateurs:</strong><br/>
                    <br/>
                    @foreach($users as $user)
                      {{ $user->email }} <a href="{{ url('/admin/delete/user',['id' => $user->id]) }}">X</a>
                      @if($user->is_admin)
                      (Admin <a href="{{ url('/admin/set/user',['id' => $user->id, 'bool' => false]) }}">X</a>)
                      @else
                      <a href="{{ url('/admin/set/user',['id' => $user->id, 'bool' => true]) }}">Devenir Admin</a>
                      @endif
                      <br/>
                    @endforeach
                    <br/>
                    <hr/>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
  <script
  src="https://code.jquery.com/jquery-3.2.0.min.js"
  integrity="sha256-JAW99MJVpJBGcbzEuXk4Az05s/XyDdBomFqNlM3ic+I="
  crossorigin="anonymous"></script>
  <script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />

@endsection
