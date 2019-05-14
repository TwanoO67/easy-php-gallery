<?php
    //https://codepen.io/amiteshchauhan/pen/QEENXX

    if(isset($_GET['step'])){
        if($_GET['step'] === 'url'){

            //préparation du fichier env de laravel
            if(!empty($_GET['api_url'])){
                $api_env_path='/var/www/html/.env';
                $txt = file_get_contents($api_env_path.".example");
                $txt = str_replace('APP_URL=http://localhost:100','APP_URL='.$_GET['api_url'],$txt);
                echo file_put_contents($api_env_path,$txt);

                exec('/var/www/html/build.sh');
            }

            return 'ok';
        }

    }

?>
<html>
<body>
<div class="container">
    <div class="row">
        <h1>Easy Photo Gallery</h1>
    </div>
	<div class="row">
		<section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Etape 1">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Etape 2">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </span>
                        </a>
                    </li>
                    <!--li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Etape 3">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                        </a>
                    </li-->

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <form role="form">
                <div class="tab-content">

                    <!--Step1 -->
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <h3>Configuration</h3>
                        <div class="bs-calltoaction bs-calltoaction-primary">
                            <div class="row">
                                <div class="col-md-12 cta-contents">
                                    <h1 class="cta-title">Bienvenue</h1>
                                    <div class="cta-desc">
                                        <p>Votre instance de Easy Photo Gallery n'est pas encore configurée.</p>
                                        <p>Suivez les étapes pour démarrer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-primary next-step">Suivant</button></li>
                        </ul>
                    </div>

                    <!--Step2 -->
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h3>Accès externe</h3>
                        <div class="bs-calltoaction bs-calltoaction-primary">
                            <div class="row">
                                <div class="col-md-12 cta-contents">
                                    <h1 class="cta-title">Quelle est votre URL externe ?</h1>
                                    <div class="cta-desc">
                                        <p>Depuis quelle URL allez vous accèder au site ?<br/>
                                            <br/>
                                            <label for="api_url">API:</label><input type="text" id="api_url" name="api_url" placeholder="http://my-external-dns-or-ip:port" /><br/>
                                            <br/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-primary" onclick="saveURL()">Démarrer</button></li>
                        </ul>
                    </div>

                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Installation</h3>
                        <div class="bs-calltoaction bs-calltoaction-primary">
                            <div class="row">
                                <div class="col-md-12 cta-contents">
                                    <h1 class="cta-title">Installation en cours</h1>
                                    <div class="cta-desc">
                                        <p>
                                          Votre version personnalisée est en cours  d'installation'.<br/>
                                          A la fin de celle-ci la page se rechargera automatiquement.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
   </div>
</div>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<script>
    function saveURL(){
        nextStep();
        $.ajax({
            url : '/?step=url&api_url='+$('#api_url').val(),
            type : 'GET',
            dataType : 'html',
            success : function(code_html, statut){ // success est toujours en place, bien sûr !
                window.location.reload();
            },
            error : function(resultat, statut, erreur){
                alert("Erreur pendant l'installation");
            }
        });
    }

    $(document).ready(function () {
        //Initialize tooltips
        $('.nav-tabs > li a[title]').tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

            var $target = $(e.target);

            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });

        $(".next-step").click(function (e) {
            nextStep();
        });
        $(".prev-step").click(function (e) {

            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);

        });
    });

    function nextStep(){
        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);
    }

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }
</script>

<style>

input {
    color: black;
}

.wizard {
  margin: 20px auto;
  background: #fff;
}

.wizard .nav-tabs {
  position: relative;
  margin: 40px auto;
  margin-bottom: 0;
  border-bottom-color: #e0e0e0;
}

.wizard > div.wizard-inner {
  position: relative;
}

.connecting-line {
  height: 2px;
  background: #e0e0e0;
  position: absolute;
  width: 80%;
  margin: 0 auto;
  left: 0;
  right: 0;
  top: 50%;
  z-index: 1;
}

.wizard .nav-tabs > li.active > a,
.wizard .nav-tabs > li.active > a:hover,
.wizard .nav-tabs > li.active > a:focus {
  color: #555555;
  cursor: default;
  border: 0;
  border-bottom-color: transparent;
}

span.round-tab {
  width: 70px;
  height: 70px;
  line-height: 70px;
  display: inline-block;
  border-radius: 100px;
  background: #fff;
  border: 2px solid #e0e0e0;
  z-index: 2;
  position: absolute;
  left: 0;
  text-align: center;
  font-size: 25px;
}
span.round-tab i {
  color: #555555;
}
.wizard li.active span.round-tab {
  background: #fff;
  border: 2px solid #5bc0de;
}
.wizard li.active span.round-tab i {
  color: #5bc0de;
}

span.round-tab:hover {
  color: #333;
  border: 2px solid #333;
}

.wizard .nav-tabs > li {
  width: 25%;
}

.wizard li:after {
  content: " ";
  position: absolute;
  left: 46%;
  opacity: 0;
  margin: 0 auto;
  bottom: 0px;
  border: 5px solid transparent;
  border-bottom-color: #5bc0de;
  transition: 0.1s ease-in-out;
}

.wizard li.active:after {
  content: " ";
  position: absolute;
  left: 46%;
  opacity: 1;
  margin: 0 auto;
  bottom: 0px;
  border: 10px solid transparent;
  border-bottom-color: #5bc0de;
}

.wizard .nav-tabs > li a {
  width: 70px;
  height: 70px;
  margin: 20px auto;
  border-radius: 100%;
  padding: 0;
}

.wizard .nav-tabs > li a:hover {
  background: transparent;
}

.wizard .tab-pane {
  position: relative;
  padding-top: 50px;
}

.wizard h3 {
  margin-top: 0;
}

@media (max-width: 585px) {
  .wizard {
    width: 90%;
    height: auto !important;
  }

  span.round-tab {
    font-size: 16px;
    width: 50px;
    height: 50px;
    line-height: 50px;
  }

  .wizard .nav-tabs > li a {
    width: 50px;
    height: 50px;
    line-height: 50px;
  }

  .wizard li.active:after {
    content: " ";
    position: absolute;
    left: 35%;
  }
}
.bs-calltoaction {
  position: relative;
  width: auto;
  padding: 15px 25px;
  border: 1px solid black;
  margin-top: 10px;
  margin-bottom: 10px;
  border-radius: 5px;
}

.bs-calltoaction > .row {
  display: table;
  width: calc(100% + 30px);
}

.bs-calltoaction > .row > [class^="col-"],
.bs-calltoaction > .row > [class*=" col-"] {
  float: none;
  display: table-cell;
  vertical-align: middle;
}

.cta-contents {
  padding-top: 10px;
  padding-bottom: 10px;
}

.cta-title {
  margin: 0 auto 15px;
  padding: 0;
}

.cta-desc {
  padding: 0;
}

.cta-desc p:last-child {
  margin-bottom: 0;
}

.cta-button {
  padding-top: 10px;
  padding-bottom: 10px;
}

@media (max-width: 991px) {
  .bs-calltoaction > .row {
    display: block;
    width: auto;
  }

  .bs-calltoaction > .row > [class^="col-"],
  .bs-calltoaction > .row > [class*=" col-"] {
    float: none;
    display: block;
    vertical-align: middle;
    position: relative;
  }

  .cta-contents {
    text-align: center;
  }
}

.bs-calltoaction.bs-calltoaction-default {
  color: #333;
  background-color: #fff;
  border-color: #ccc;
}

.bs-calltoaction.bs-calltoaction-primary {
  color: #fff;
  background-color: #337ab7;
  border-color: #2e6da4;
}

.bs-calltoaction.bs-calltoaction-info {
  color: #fff;
  background-color: #5bc0de;
  border-color: #46b8da;
}

.bs-calltoaction.bs-calltoaction-success {
  color: #fff;
  background-color: #5cb85c;
  border-color: #4cae4c;
}

.bs-calltoaction.bs-calltoaction-warning {
  color: #fff;
  background-color: #f0ad4e;
  border-color: #eea236;
}

.bs-calltoaction.bs-calltoaction-danger {
  color: #fff;
  background-color: #d9534f;
  border-color: #d43f3a;
}

.bs-calltoaction.bs-calltoaction-primary .cta-button .btn,
.bs-calltoaction.bs-calltoaction-info .cta-button .btn,
.bs-calltoaction.bs-calltoaction-success .cta-button .btn,
.bs-calltoaction.bs-calltoaction-warning .cta-button .btn,
.bs-calltoaction.bs-calltoaction-danger .cta-button .btn {
  border-color: #fff;
}

blockquote {
  border-left: none;
}

.quote-badge {
  background-color: rgba(0, 0, 0, 0.2);
}

.quote-box {
  overflow: hidden;
  margin-top: -50px;
  padding-top: -100px;
  border-radius: 17px;
  background-color: #4adfcc;
  margin-top: 25px;
  color: white;
  width: 325px;
  box-shadow: 2px 2px 2px 2px #e0e0e0;
}

.quotation-mark {
  margin-top: -10px;
  font-weight: bold;
  font-size: 100px;
  color: white;
  font-family: "Times New Roman", Georgia, Serif;
}

.quote-text {
  font-size: 19px;
  margin-top: -65px;
}


</style>

</body>
</html>
