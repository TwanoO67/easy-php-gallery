<?php
$thumbor_url = "/convert/unsafe/";
$format_date = "Y/m/d G:i:s";

$title = "Gallerie Photo";

$base_dir = "/mydata";
if( isset($_GET['dir'])){
	$cur_dir = base64_decode($_GET['dir']);
	$title = "Gallerie ".str_replace($base_dir, '', $cur_dir);
}
else{
	$cur_dir = "";
}





function human_filesize($bytes, $decimals = 2) {
    $size = array('o','Ko','Mo','Go','To','Po','Eo','Zo','Yo');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

function getImgLink($file,$resolution=""){
	global $cur_dir,$thumbor_url;
	return $thumbor_url.$resolution.'/'.urlencode(substr($cur_dir,1).'/'.$file->getFilename());
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php echo $title; ?></title>

<!-- Google fonts -->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:600' rel='stylesheet' type='text/css'>

<!-- font awesome -->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<!-- bootstrap -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />

<!-- animate.css -->
<link rel="stylesheet" href="assets/animate/animate.css" />
<link rel="stylesheet" href="assets/animate/set.css" />

<!-- gallery -->
<link rel="stylesheet" href="assets/gallery/blueimp-gallery.min.css">

<!-- favicon -->
<link rel="shortcut icon" href="images/favicon.jpg" type="image/x-icon">
<link rel="icon" href="images/favicon.jpg" type="image/x-icon">


<link rel="stylesheet" href="assets/style.css">

</head>

<body>


<div id="home">
<!-- Slider Starts -->
<div class="banner">
          <img id="fondecran" src="images/back.jpg" alt="banner" class="img-responsive" style="margin-left: auto; margin-right: auto;">
          <div class="caption">
            <div class="caption-wrapper">
              <div class="caption-info">
              <!--img src="images/profile.jpg" class="img-circle profile"-->
              <h1 class="animated bounceInUp"><?php echo $title; ?></h1>
              <!--p class="animated bounceInLeft">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
             <div class="animated bounceInDown"><a href="#works" class="btn btn-default explore">view My Works</a></div-->
              </div>
            </div>
          </div>
</div>
<!-- #Slider Ends -->
</div>









<!-- works -->
<div id="works"  class=" clearfix grid">

<?php
	//on commence par listé les dossier
	foreach (new DirectoryIterator($base_dir.'/'.$cur_dir) as $fileInfo) {
		//on passe les liens pointé
		if($fileInfo->isDot()) continue;
		//on creer des liens pour les dossiers
		if($fileInfo->isDir()){

			$dir_link = "/?dir=".base64_encode($cur_dir.'/'.$fileInfo->getFilename());
		?>
			<figure class="effect-oscar  wowload fadeInUp">
	        	<img src="/images/folder.png" style="margin-left: auto; margin-right: auto;" alt="dossier"/>
		        <figcaption>
		            <h2 onclick="document.location='<?php echo $dir_link ?>'"><?php echo $fileInfo->getFilename(); ?></h2>
		            <p>
			            <?php echo date($format_date,$fileInfo->getMTime()); ?><br>
						<a href="<?php echo $dir_link ?>" title="<?php echo $fileInfo->getFilename() ?>">
							Ouvrir le dossier
						</a>
		            </p>
		        </figcaption>
		    </figure>
	    <?php
		}
	}


	$first = false;
	foreach (new DirectoryIterator($base_dir.'/'.$cur_dir) as $fileInfo) {
		//on passe les liens pointé
		if($fileInfo->isDot()) continue;
		//on passe les dossiers
		if($fileInfo->isDir()) continue;

		$mimetype = mime_content_type($fileInfo->getPathname());

		//on filtre les fichiers qui ne sont pas des images
		if( strpos( $mimetype, "image") === false ) continue;

		//on recupere la premiere image pour s'en servir de fond d'ecran pour l'album
		if(!$first){
			$first = getImgLink($fileInfo,"1920x700");
		}
		?>
		<figure class="effect-oscar wowload fadeInUp">
	        <img src="<?php echo getImgLink($fileInfo,"640x360") ?>" alt="<?php echo $fileInfo->getFilename() ?>"/>
	        <figcaption>
	            <!--h2><?php echo $fileInfo->getFilename(); ?></h2-->
	            <p>
		            <?php echo $fileInfo->getFilename(); ?><br>
		            <?php echo $mimetype; ?><br>
		            <?php echo date($format_date,$fileInfo->getMTime()); ?><br>
								<?php echo human_filesize($fileInfo->getSize()); ?><br>
								<a
									href="<?php echo getImgLink($fileInfo,"1920x1080") ?>"
									title="<?php echo $fileInfo->getFilename() ?>" data-gallery>
									Agrandir
								</a>
	            </p>
	        </figcaption>
	    </figure>
		<?php
	}

	//si une image a été trouvé
	if($first){
		echo "<script> document.getElementById('fondecran').src = '".$first."'; </script>";
	}

?>






</div>
<!-- works -->


<!--div id="testimonials" class="container spacer ">
	<h2 class="text-center  wowload fadeInUp">Testimonails</h2>
  <div class="clearfix">
    <div class="col-sm-6 col-sm-offset-3">


    <div id="carousel-testimonials" class="carousel slide testimonails  wowload fadeInRight" data-ride="carousel">
    <div class="carousel-inner">
      <div class="item active animated bounceInRight row">
      <div class="animated slideInLeft col-xs-2"><img alt="portfolio" src="images/team/1.jpg" width="100" class="img-circle img-responsive"></div>
      <div  class="col-xs-10">
      <p> I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. </p>
      <span>Angel Smith - <b>eshop Canada</b></span>
      </div>
      </div>
      <div class="item  animated bounceInRight row">
      <div class="animated slideInLeft col-xs-2"><img alt="portfolio" src="images/team/2.jpg" width="100" class="img-circle img-responsive"></div>
      <div  class="col-xs-10">
      <p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.</p>
      <span>John Partic - <b>Crazy Pixel</b></span>
      </div>
      </div>
      <div class="item  animated bounceInRight row">
      <div class="animated slideInLeft  col-xs-2"><img alt="portfolio" src="images/team/3.jpg" width="100" class="img-circle img-responsive"></div>
      <div  class="col-xs-10">
      <p>On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue.</p>
      <span>Harris David - <b>Jet London</b></span>
      </div>
      </div>
  </div>

   	<ol class="carousel-indicators">
    <li data-target="#carousel-testimonials" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-testimonials" data-slide-to="1"></li>
    <li data-target="#carousel-testimonials" data-slide-to="2"></li>
  	</ol>

  </div-->



    </div>
  </div>



</div>















<!--div class="footer text-center spacer">
<p class="wowload flipInX"><a href="#"><i class="fa fa-facebook fa-2x"></i></a> <a href="#"><i class="fa fa-instagram fa-2x"></i></a> <a href="#"><i class="fa fa-twitter fa-2x"></i></a> <a href="#"><i class="fa fa-flickr fa-2x"></i></a> </p>
Copyright 2014 Cyrus Creative Studio. All rights reserved.
</div-->



<a href="#home" class="gototop "><i class="fa fa-angle-up  fa-3x"></i></a>





<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title">Title</h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
</div>



<!-- jquery -->
<script src="assets/jquery.js"></script>



<!-- wow script -->
<script src="assets/wow/wow.min.js"></script>


<!-- boostrap -->
<script src="assets/bootstrap/js/bootstrap.js" type="text/javascript" ></script>

<!-- jquery mobile -->
<script src="assets/mobile/touchSwipe.min.js"></script>
<script src="assets/respond/respond.js"></script>

<!-- gallery -->
<script src="assets/gallery/jquery.blueimp-gallery.min.js"></script>




<!-- custom script -->
<script src="assets/script.js"></script>

</body>
</html>
