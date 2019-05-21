@extends('layouts.paper')

@section('head')
  <title>{{ $title }}</title>
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
  <script>
    function goto(url){
        window.location = url;
    }
  </script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')

  <a href="/" class="btn btn-default explore">Retour</a>&nbsp;&nbsp;&nbsp;

  <a class="navbar-brand" href="#">{{ $title }}</a>

  <button class="btn btn-primary btn-sm" onclick="create()">
      <i class="fas fa-folder-plus"></i> Créer un Album
  </button>
@endsection

@section('content')

<div class="content">

    <div class="row">
      <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">Albums</h4>
                </div>
                <div class="card-content">
                    @foreach ($albums as $album)
                        <button class="btn btn-default btn-fill btn-wd" onclick="goto('{{ route('album', ['id' => $album->id]) }}')">{{$album->name}}</button>
                    @endforeach
                    @if(count($albums) === 0)
                        <span>Pas d'album encore disponible. Il faut attendre un import ?</span>
                    @endif

                </div>

            </div>
        </div>
    </div>

</div>
@endsection


@section('footer')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
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


    async function create() {

        const {value: myJSObject} = await Swal.fire({
            title: 'Créer un dossier',
            html:
                '<label for="nom">Nom</label><input id="nom" class="swal2-input" />'+
                '<label for="directory">Dossier d\'upload</label><input id="directory" class="swal2-input" />'+
                '<label for="access_level>Autoriser l\'upload ?</label><input id="access_level" type="checkbox" />'
            ,
            focusConfirm: false,
            onBeforeOpen: () => {
                /*Swal.showLoading()
                timerInterval = setInterval(() => {
                Swal.getContent().querySelector('strong')
                    .textContent = Swal.getTimerLeft()
                }, 100)*/

                $( "#directory" ).autocomplete({
                    source: "{{ route('storage_autocomplete') }}",
                    minLength: 3,
                    select: function(event, ui) {
                        $('#directory').val(ui.item.value);
                    }
                });
            },
            preConfirm: () => {
                return {
                    'name': $('#nom').val(),
                    'directory': $('#directory').val(),
                    'theme': 'paper',
                    'access_level': $('#access_level').attr('checked')?'RW':'R',
                }
            }
        })

        if(myJSObject.name.length > 0 ){
            var url = "{{ route('album_create') }}";
            $.ajax(url, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : JSON.stringify(myJSObject),
                contentType : 'application/json',
                type : 'POST'
            }).done(function( data ) {
                window.location.reload();
            });
        }


    }


</script>
@endsection
