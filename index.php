<?php error_reporting(E_ALL & ~E_NOTICE); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">


	<title>Scraper</title>

	<!-- Bootstrap core CSS -->
	<link href="dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="dist/css/dashboard.css" rel="stylesheet">
	<!-- Font Awesome Icons -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />


	<![endif]-->
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Awok Scraper Test</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">

		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="jumbotron">
 
				<div class="input-group">
					<input type="text" placeholder="Search..." class="form-control" name="searchbox"  id="searchbox" >
              <span class="input-group-btn">
                <button class="btn btn-flat" id="search-btn" name="search">
	                <i class="fa fa-search"></i>
                </button>

              </span>
				</div>

           
			 

		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div id="message">
				<div style="padding: 5px;">
					<div id="inner-message" class="alert alert-info" style="text-align: center">
						<b>Seach in Progress </b>
					</div>
				</div>
			</div>

			<style>
				#message {
					position: fixed;
					display: none;
					top: 0;
					left: 0;
					width: 100%;
					z-index: 10000;
				}
				#inner-message {
					margin: 0 auto;
				}

			</style>
			<h1 class="page-header">Result</h1>

			<div class="resultbox" >


			</div>
            <div class="alert alert-danger fade in" style="display: none" id="errorbox"><strong> Oops! </strong> Sorry no result was found </div>


		</div>
	</div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>

<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script src="dist/js/custom.js"></script>
</body>
</html>
