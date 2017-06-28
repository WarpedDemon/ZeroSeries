<?php
session_start();
include_once('functions.php');
$imageList = array();
$tempimageList = array();

class Image {
	var $src;
	var $title;
	function __construct( $par1, $par2 ) {
	   $this->src = $par1;
	   $this->title = $par2;
	}
	function setSrc($src) {
		$this->src = $src;
	}
	
	function getSrc() {
		return $this->src;
	}
	
	function setTitle($title) {
		$this->title = $title;
	}
	
	function getTitle() {
		return $this->title;
	}
}
if(!isset($_SESSION)) {
	$_SESSION['status'] = false;
}

if($_POST) {
	if(isset($_POST['input_username'])) {
		if(isset($_POST['input_password'])) {
			$result = loginUser($_POST['input_username'], $_POST['input_password']);
			if($result == false) {
				echo "Failed to find user.";
			} else {
				$_SESSION['status'] = $result['Status'];
				$_SESSION['username'] = $result['Username'];
				echo '<span style="float:right;padding-right: 20px;">Welcome back, ' . $_SESSION['username'] . "</span>";
			}
		}
	}
}


try {
	$tempimageList = getImages();
	if($tempimageList == false) { 
		echo 'no images exist'; 
	} else if($tempimageList == "error_connection") { 
		throw new Exception("Error with connection to database!");
	} else {
		foreach($tempimageList as $key=>$value) {
			$newImage = new Image($value['src'], $value['title']);
			array_push($imageList, $newImage);
		}
	}
}
catch(Exception $e) {
	print $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Zero Series | Home</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- Theme CSS -->
    <link href="css/grayscale.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">
                    <i class="fa fa-play-circle"></i> <span class="light">Zero</span> Series
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#about">About Me</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#gallery">Gallery</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#contact">Contact</a>
                    </li>
					<?php
					if($_SESSION['status'] == false) {
					?>
					<li>
						<a href="#loginModal" data-toggle="modal" data-target="#loginModal">Login</a>
					</li>
					<?php
					} else {
					?>
					<li>
						<a href="upload.php"><span class="glyphicon glyphicon-upload"></span> Upload</a>
					</li>
					<li>
						<a href="logout.php"><span class="glyphicon glyphicon-share-alt"></span> Logout</a>
					</li>
					<?php
					}
					?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">Zero Series</h1>
                        <p class="intro-text">Photography Gallery
                            <br>by Mitchell Holland</p>
                        <a href="#gallery" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
	
	<section id="gallery" class="container content-section text-center">
	     <h2>Gallery</h2><br/><br/><br/>
		<div class="row" style="display: inline-block;">
			<?php
				if(is_array($imageList)) {
					foreach($imageList as $key => $image) {
						$src = $image->getSrc();
						$title = $image->getTitle();
						//echo $src;
						//echo $title;
						?>
						<div class="col-lg-4" style="display: inline-block !important;"><img src='<?php echo $src ?>' alt='<?php echo $title ?>' /></div>
						<?php
					}
					
				} else {
					echo 'No images found!';
				}
			?>
		</div>
	</section>-


    <!-- Contact Section 
    <section id="contact" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact Me</h2>
                <p>Feel free to email me regarding any bookings, or to just say hello!</p>
                <p><a href="#">mitcheyyboi97@gmail.com</a>
                </p>
                <ul class="list-inline banner-social-buttons">
                    <li>
                        <a href="#" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                    </li>
                    <li>
                        <a href="#" class="btn btn-default btn-lg"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Facebook</span></a>
                    </li>
                    <li>
                        <a href="#" class="btn btn-default btn-lg"><i class="fa fa-google-plus fa-fw"></i> <span class="network-name">Google+</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p style="font-size: 16px !important;">Copyright &copy; Zero Series 2017</p>
        </div>
    </footer>
	
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h2 class="modal-title" id="exampleModalLongTitle" style="text-align:center;color:black">Login</h2>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form name="loginForm" method="post">
			  <div class="modal-body" style="text-align:center;color:black">
				Username: <input id="usernameInput" name="input_username" placeholder="Username..." />
				<br/>
				<br/>
				Password: <input id="passwordInput" type="password" name="input_password" placeholder="Password" />
			  </div>
			  <div class="modal-footer">
				<input type="submit" class="btn btn-danger" data-dismiss="modal" value="Close">
				<input type="submit" class="btn btn-success" value="Login">
			  </div>
		  </form>
		</div>
	  </div>
	</div>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

    <!-- Theme JavaScript -->
    <script src="js/grayscale.min.js"></script>

</body>

</html>
