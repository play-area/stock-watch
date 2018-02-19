<!DOCTYPE html>
<html lang="en">

  <head>
	
	<?php require 'includes/head.php'?>
    
  </head>

  <body>

    <?php require 'includes/navigation.php'?>
    
    <!-- Page Content -->
    <div class="container">
	
	<h2 class="my-4">Options Analysis</h2>
	
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Home</a>
		</li>
		<li class="breadcrumb-item active">Options</li>
	</ol>
	
	<!-- .row -->
	<div class="row alerts-row">
		<div class="alert alert-success">
			<a href="#" class="close-alert" >&times;</a>
			<div>
			</div>
		</div>
		<div class="alert alert-info">
			<a href="#" class="close-alert" >&times;</a>
			<div>
			</div>
		</div>
		<div class="alert alert-danger">
			<a href="#" class="close-alert" >&times;</a>
			<div>
			</div>
		</div>
	</div>
	<!-- ./row -->
      
	<!-- .row -->
    <div class="row">
        <div class="col-lg-4">
			<h3>Bank Nifty Options</h3>
			<form class="options-form" method="post" onsubmit="calculateOptions()">
				<div class="dropdown form-group">
					<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Symbol
					<span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="#">Nifty</a></li>
						<li><a href="#">Bank Nifty</a></li>
					</ul>
				</div> 
				<div class="dropdown form-group">
					<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Time Range
					<span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a href="#">1 Year</a></li>
						<li><a href="#">3 Years</a></li>
						<li><a href="#">5 Years</a></li>
					</ul>
				</div> 
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Calculate</button>
				</div>
			</form>
        </div>
		<div class="col-lg-8">
			<h3>Results</h3>
		</div>
    </div>
    <!-- /.row -->
	  
	</div>
    <!-- /.container -->

    <?php require 'includes/footer.php'?>
    <?php require 'includes/foot.php'?>

  </body>

</html>
