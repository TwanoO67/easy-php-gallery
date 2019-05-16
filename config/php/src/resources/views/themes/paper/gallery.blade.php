@extends('layouts.paper')

@section('head')
  <title>{{ $title }}</title>
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
  <link href="https://unpkg.com/nanogallery2/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css">
  <link href="https://transloadit.edgly.net/releases/uppy/v0.30.3/uppy.min.css" rel="stylesheet">
  <style>
    /* selectable */

    .s-noselect {
        -webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;
    }

    #s-rectBox {
        position: absolute;
        z-index: 1090;
        border:2px dashed #cbd3e3;
    }

    div.nGY2GThumbnail.active{
      border-style: solid;
      border-width: 5px;
      border-color: #007bff;
    }

  </style>
@endsection

@section('title')

  @if($parent)
  <a href="{{$parent}}" class="btn btn-default explore">Retour</a>&nbsp;&nbsp;&nbsp;
  @endif

  <a class="navbar-brand" href="#">{{ $title }}</a>
  <button class="btn btn-primary btn-sm" onclick="deleteCurrent()">
    <i class="fas fa-trash"></i>
  </button>
@endsection

@section('content')

<div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-body">
            <button class="btn btn-primary btn-sm" onclick="startScan()">
              <i class="fab fa-searchengin"></i> Scanner le dossier
            </button>

            <button class="btn btn-primary btn-sm" id='btn_selection' onclick="toggleSelectionMode()" ></button>

            <button class="btn btn-primary btn-sm" id='btn_dir_create' onclick="createSubdir()" ></button>

            <button class="btn btn-primary btn-sm" id='btn_move' onclick="moveFiles()">
              <i class="fas fa-arrows-alt"></i> Deplacer
            </button>

            <button class="btn btn-primary btn-sm" id='btn_album' onclick="addFilesToAlbum()">
            <i class="fas fa-arrows-alt"></i> Ajouter à l'album
            </button>

            <button class="btn btn-primary btn-sm" id='btn_delete' onclick="deleteFiles()">
              <i class="fas fa-trash"></i> Supprimer
            </button>
          </div>
        </div>
      </div>
    </div>



      <div class="row">

      <div class="col-md-6">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Sous-Dossier</h5>

            <p class="card-category"> ( {{ count($directories) }} dossiers )</p>
          </div>
          <div class="card-body zone " id="subdir_zone">
              @foreach ($directories as $dir)
                  <a class="btn btn-default" href="{{ $dir['dirlink'] }}" data-directory="{{ $dir['basename'] }}">
                    <i class="nc-icon nc-box"></i> {{ $dir['basename'] }}
                  </a>
              @endforeach
          </div>
          <div class="card-footer ">
            <hr>
            <div id="subdir_footer">
              <i class="fa fa-history"></i> Aucune selection
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Ajouter vos fichiers</h5>
          </div>
          <div class="card-body ">
            <div id="drag-drop-area"></div>
          </div>
        </div>
      </div>

      @if(count($files) > 0)
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Photos</h5>
            <p class="card-category">( {{ count($files) }} images )</p>
          </div>
          <div class="card-body zone " id="file_zone">
            <div id="your_nanogallery2" data-nanogallery2 >
              <?php $first = false; ?>
              @foreach ($files as $file)
                  <a href="{{ $file['img_links']['full'] }}" data-ngThumb="{{ $file['img_links']['small'] }}" data-ngdesc="{{ $file['filename'] }}">
                  </a>
              @endforeach
            </div>
          </div>
          <div class="card-footer ">
            <hr>
            <div id="file_footer">
              <i class="fa fa-history"></i> Updated 3 minutes ago
            </div>
          </div>
        </div>
      </div>
      @endif


  </div>
</div>
@endsection

@section('footer')
  <script type="text/javascript" src="https://unpkg.com/nanogallery2/dist/jquery.nanogallery2.min.js"></script>
  <script type="text/javascript" src="/assets/js/plugins/selectables.js"></script>
  <script src="https://transloadit.edgly.net/releases/uppy/v0.30.3/uppy.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script>
    var directory = {!! json_encode($directory) !!};

    var uppy = Uppy.Core({ meta: { directory: directory } })
      .use(Uppy.Dashboard, {
        inline: true,
        target: '#drag-drop-area'
      })
      .use(Uppy.XHRUpload, {
        endpoint: '/api/file/upload',
        body: JSON.stringify({
        }),
      })

      // Todo : ajout de vérification de l'upload + rafraichir la page
    uppy.on('complete', (result) => {
      console.log('Upload complete! We’ve uploaded these files:', result.successful)
      window.location.refresh();
    })

    function statusUpdater() {
			$.ajax({
				'url': '/api/scan/status',
			}).done(function(r) {
        console.log(r);
        $('#scan_done').html(r.done);
        $('#scan_todo').html(r.todo);
        //tant que c'est pas finis on relance
				if(r.done < r.todo) {
          setTimeout(() => {
            statusUpdater();
          }, 500);
				}
			  })
			  .fail(function() {
				  console.log( "An error has occurred... We could ask Neo about what happened, but he's taken the red pill and he's at home sleeping" );
			  });
		}

    function startScan() {
      color = 'primary';

      $.notify({
        icon: "nc-icon nc-settings-gear-65",
        message: "Scan en cours <span id='scan_done'>0</span> / <span id='scan_todo'>0</span>"

      }, {
        type: color,
        timer: 0,
        placement: {
          from: 'top',
          align: 'right'
        }
      });
      $.ajax({
        'url': '/api/scan/start',
        'path': directory
      }).done(function(r){
        statusUpdater();
      });

    }

    function updateActiveSubDirs(){
        var count = getSelectedFoldersHTML().length;
        var icon = '<i class="fa fa-history"></i>';
        var element = $('#subdir_footer');
        if(count === 0){
            element.html(icon+' Aucun dossier selectionné');
        }
        else if(count === 1){
            element.html(icon+' 1 dossier selectionnée');
        }
        else if(count > 1){
            element.html(icon+' '+count+" dossiers selectionnées");
        }
        console.log(count);
    }

    function updateActiveFiles(){
        var count = getSelectedFilesHTML().length;
        var icon = '<i class="fa fa-history"></i>';
        var element = $('#file_footer');
        if(count === 0){
            element.html(icon+' Aucune photo selectionnée');
        }
        else if(count === 1){
            element.html(icon+' 1 photo selectionnée');
        }
        else if(count > 1){
            element.html(icon+' '+count+" photos selectionnées");
        }
        console.log(count);
    }

    function getSelectedFoldersHTML(){
      return $('#subdir_zone a.active');
    }

    function getSelectedFilesHTML(){
      return $('#file_zone div.nGY2GThumbnail.active');
    }

    function getSelectedFiles(){
      var files = [];
      //s'il y a des fichiers dans la gallery courante
      if($('#your_nanogallery2').length > 0){
        //recuperation des fichiers de la galleries
        var data = $('#your_nanogallery2').nanogallery2('data');
        files = data.items.filter(function(item){
            if(item.$elt && item.$elt[0].className === "nGY2GThumbnail active"){
                return true;
            }
            return false;
        });
        //conversion des src vers le path
        files = files.map(function(gal_item){
            let url = gal_item.src.replace('/convert/unsafe/0x0','');
            return url;
        });
      }

      return files;
    }

    function getSelectedDirs(){
      //recuperation des dossiers
      var dir = [];
      getSelectedFoldersHTML().each((index,d) => {
        dir.push( $(d).data('directory') );
      });
      return dir;
    }

    //recuperation des fichiers et dossiers
    function getSelectedList(){
      var dir = getSelectedDirs()
      var files = getSelectedFiles()
      return dir.concat(files);
    }

    function moveToDirAPI(myJSObject){
      var url = "{{ route('storage_create') }}";
      $.ajax(url, {
        data : JSON.stringify(myJSObject),
        contentType : 'application/json',
        type : 'POST'
      }).done(function( data ) {
        window.location.reload();
      })
      .fail(function(error) {
        console.log(error);
        $.notify({
            icon: "nc-icon nc-settings-gear-65",
            message: "error.message"

        }, {
            type: "error",
            timer: 5,
            placement: {
                from: 'top',
                align: 'right'
            }
        });
      });
    }

    function addToAlbumAPI(myJSObject){
      var url = "{{ route('album_files') }}";
      $.ajax(url, {
        data : JSON.stringify(myJSObject),
        contentType : 'application/json',
        type : 'POST'
      }).done(function( data ) {
        window.location.reload();
      })
      .fail(function(error) {
        console.log(error);
        $.notify({
            icon: "nc-icon nc-settings-gear-65",
            message: "error.message"

        }, {
            type: "error",
            timer: 5,
            placement: {
                from: 'top',
                align: 'right'
            }
        });
      });
    }

    function deleteApi(myJSObject){
      var url = "{{ route('storage_delete') }}";
        $.ajax(url, {
          data : JSON.stringify(myJSObject),
          contentType : 'application/json',
          type : 'POST'
        }).done(function( data ) {
          window.location.reload();
        }).fail(function(error) {
            console.log(error);
            $.notify({
                icon: "nc-icon nc-settings-gear-65",
                message: "error.message"
            }, {
                type: "error",
                timer: 5,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
        });
    }

    function deleteCurrent(){
      if( confirm( "Etes vous sur de vouloir supprimer le dossier courant ? \n"
      +" - "+directory
      ) ){
        var myJSObject = {
          'files': [],
          'directories': [ directory ]
        }
        deleteApi(myJSObject);

      }
    }

    function deleteFiles(){
      var selected = getSelectedFiles();
      var selected_dir = getSelectedDirs();

      if( confirm( "Etes vous sur de vouloir supprimer ? \n"
      +" - "+selected.length+" fichiers \n"
      +" - "+selected_dir.length+" dossiers"
      ) ){
        var myJSObject = {
          'files': selected,
          'directories': selected_dir
        }
        deleteApi(myJSObject);

      }

    }

    async function moveFiles(){
        var selected = getSelectedList();

        const {value: name} = await Swal.fire({
            title: 'Vers où depasser les fichiers ?',
            input: 'select',
            inputOptions: {
                @foreach ($child_directories as $dir)
                    '{{$dir}}': '{{$dir}}',
                @endforeach
            },
            inputPlaceholder: 'Selectionner un dossier',
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                if (value !== '') {
                    resolve()
                } else {
                    resolve('Merci de choisir un dossier')
                }
                })
            }
        });

        if (name) {
            moveToDirAPI({
                'destination_directory': name,
                'files': selected
            });
        }

    }

    async function addFilesToAlbum(){

        @if( count($albums) === 0 )
            Swal.fire("Veuillez d'abord creer un album");
            return false
        @endif

        const {value: id} = await Swal.fire({
            title: 'Ajouter a l\'album ?',
            input: 'select',
            inputOptions: {
                @foreach ($albums as $dir)
                    '{{$dir->id}}': '{{$dir->name}}',
                @endforeach
            },
            inputPlaceholder: 'Selectionner un album',
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                if (value !== '') {
                    resolve()
                } else {
                    resolve('Merci de choisir un album')
                }
                })
            }
        });

        if (id) {
            addToAlbumAPI({
                'album_id': id,
                'files': getSelectedFiles(),
                'folders' : getSelectedDirs()
            });
        }

    }

    async function createSubdir(){
      var selected = getSelectedList();

    const {value: name} = await Swal.fire({
        title: "Quel nom donner au dossier ?",
        input: 'text',
        inputPlaceholder: 'dossier'
    })

      if(!name || name.length === 0){
        return false;
      }

      var myJSObject = {
        'new_directory': directory+'/'+name,
        'files': selected
      }
      moveToDirAPI(myJSObject);
    }

    btn_mode_selection = $('#btn_selection');

    label_mode_selection_on='<i class="fas fa-hand-pointer"></i> Mode selection';
    label_mode_selection_off='<i class="fas fa-hand-pointer"></i> Desactiver la selection';

    btn_dir_create = $('#btn_dir_create');
    label_create_single='<i class="fas fa-folder-plus"></i> Créer un dossier';
    label_create_and_fill='<i class="fas fa-folder-plus"></i> Créer un dossier avec la selection';

    btn_move = $('#btn_move');
    btn_delete = $('#btn_delete');
    btn_album = $('#btn_album');

    btn_mode_selection.html(label_mode_selection_on);
    btn_dir_create.html(label_create_single);
    btn_move.hide();
    btn_delete.hide();
    btn_album.hide();

    function toggleSelectionMode(){
        if(subdir_enabled){
            subdir_selection.disable();
            file_selection.disable();
            getSelectedFoldersHTML().removeClass('active');
            getSelectedFilesHTML().removeClass('active');
            updateActiveSubDirs();
            updateActiveFiles();
            btn_mode_selection.html(label_mode_selection_on);
            btn_dir_create.html(label_create_single);
            btn_move.hide();
            btn_delete.hide();
            btn_album.hide();
        } else {
            subdir_selection.enable();
            file_selection.enable();
            btn_mode_selection.html(label_mode_selection_off);
            btn_dir_create.html(label_create_and_fill);
            btn_move.show();
            btn_delete.show();
            btn_album.show();
        }
        subdir_enabled = !subdir_enabled;
    }

    $(document).ready(function() {
        subdir_enabled = false;
        subdir_selection = new Selectables({
            elements: 'a',
            zone: '#subdir_zone',
            selectedClass: 'active', // class name to apply to seleted items
            moreUsing: 'ctrlKey', //altKey,ctrlKey,metaKey   // add more to selection
            enabled: false, //false to .enable() at later time

            start: function(){
                console.log('on start');
                console.log('Starting selection on ' + this.elements + ' in ' + this.zone);
            }, //  event on selection start
            stop: function(){
                console.log('on stop');
                console.log('Stopped selection on ' + this.elements + ' in ' + this.zone);

            }, // event on selection end
            onSelect: function(el){
                console.log('on select');
                updateActiveSubDirs();
            }, // event fired on every item when selected.
            onDeselect: function(el){
                console.log('on deselect');
                updateActiveSubDirs();
            } // event fired on every item when selected.
        });

        file_selection = new Selectables({
            elements: '.nGY2GThumbnail',
            zone: '#file_zone',
            selectedClass: 'active', // class name to apply to seleted items
            moreUsing: 'shiftKey', //altKey,ctrlKey,metaKey   // add more to selection
            enabled: false, //false to .enable() at later time

            start: function(){
                console.log('on start');
                console.log('Starting selection on ' + this.elements + ' in ' + this.zone);
            }, //  event on selection start
            stop: function(){
                console.log('on stop');
                console.log('Stopped selection on ' + this.elements + ' in ' + this.zone);

            }, // event on selection end
            onSelect: function(el){
                console.log('on select');
                updateActiveFiles();
            }, // event fired on every item when selected.
            onDeselect: function(el){
                console.log('on deselect');
                updateActiveFiles();
            } // event fired on every item when selected.
        });

    })

  </script>
@endsection
