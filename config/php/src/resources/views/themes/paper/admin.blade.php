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
                    <strong>Albums partagés:</strong><br/>
                    <br/>
                    @foreach($albums as $album)
                      album: {{ $album->directory }} -
                      Droits: {{ $album->access_level }} -
                      Créateur: {{ $album->user->email }} -
                      Thême: {{ $album->theme }} -
                      <a href="{{ url('/gallery',['id' => $album->id]) }}"> Voir la gallerie</a>

                      <a href="{{ route('album_delete',['id' => $album->id]) }}"> Supprimer</a>
                      <br/>
                    @endforeach
                    @if(count($albums) === 0)
                        Aucun album partagé
                    @endif
                    <br/>
                    <hr/>
                    <br/>
                    <b>Creer un album partagé:</b><br/>
                    <form class="form" method="POST" action="{{ route('album_create') }}">
                        @csrf
                        <!--div class="form-group">
                            <label for="user_id" class="col-md-4 col-form-label text-md-right">
                                {{ __('Utilisateur') }}
                            </label>
                            <select id="user_id" name="user_id">
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->email}}</option>
                                @endforeach
                            </select>
                        </div-->
                        <div class="form-group">
                            <label for="name" class="col-md-4 col-form-label text-md-right">
                                {{ __('Nom') }}
                            </label>
                            <input type='text' id="name" name="name" />
                        </div>

                        <div class="form-group">
                            <label for="access_level" class="col-md-4 col-form-label text-md-right">
                                {{ __('Niveau d acces') }}
                            </label>
                            <select id="access_level" name="access_level">
                                @foreach($access as $acc => $label)
                                <option value="{{$acc}}" >{{$label}}</option>
                                @endforeach
                                <!-- add select R -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="directory" class="col-md-4 col-form-label text-md-right">
                                {{ __('Dossier pour les uploads') }}
                            </label>
                            {{-- Form::select('directory', $directories, '') --}}
                            <input type="text" id="directory" name="directory" placeholder="Chercher un dossier" />
                        </div>

                        <input type='hidden' name='theme' value="paper" />

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Creer') }}
                            </button>
                        </div>
                    </form>


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
  <script>
  $(function()
  {
  	 $( "#directory" ).autocomplete({
  	  source: "admin/autocomplete",
  	  minLength: 3,
  	  select: function(event, ui) {
  	  	$('#directory').val(ui.item.value);
  	  }
  	});
  });
  </script>
@endsection
