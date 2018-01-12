<!DOCTYPE html>
<html lang="en">

  <head>
	
	<?php require 'includes/head.php'?>
    
  </head>

  <body>

    <?php require 'includes/navigation.php'?>
    <?php require 'includes/header.php'?>

    <!-- Page Content -->
    <div class="container">
	<h2 class="my-4">Welcome to Stock Watch</h2>
	
	<!-- .row -->
	<div class="row alerts-row">
		<div class="alert alert-success ">
			Stock(s) added to Watch List
		</div>
		<div class="alert alert-danger ">
			Stock(s) removed from Watch List
		</div>
	</div>
	<!-- ./row -->
      

    <!-- .row -->
    <div class="row">
        <div class="col-lg-6">
			<h3>Search Stocks Here</h3>
			<form class="stock-search-form">
				<div class="row">
					<div class="col-sm-4">
						<div class="dropdown market-dropdown">
						<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Markets<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="#">NSE</a></li>
								<li><a href="#">BSE</a></li>
								<li><a href="#">MCX</a></li>
								<li><a href="#">NCDEX</a></li>
								<li><a href="#">FOREX</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="dropdown stock-dropdown">
						<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sector<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="#">Banking</a></li>
								<li><a href="#">Metal</a></li>
								<li><a href="#">Auto</a></li>
								<li><a href="#">Pharma</a></li>
								<li><a href="#">FMCG</a></li>
								<li><a href="#">IT</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="dropdown price-dropdown">
						<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Price Range<span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="#">0-50</a></li>
								<li><a href="#">50-100</a></li>
								<li><a href="#">100 above</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<h5> or </h5>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search">
							<div class="input-group-btn">
							  <button class="btn btn-default" type="submit">
								<i class="glyphicon glyphicon-search"></i>
							  </button>
							</div>
						</div>
					</div>
				</div>
				<div class="row blank-row-1">
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="input-group">
							<button class="btn btn-success" type="submit">
								Get Results<i class="glyphicon glyphicon-search"></i>
							 </button>
						</div>
					</div>
				</div>
			</form>
        </div>
		
        <div class="col-lg-6">
			<h3>My Watch List</h3>
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>Market</th>
						<th>Stock</th>
						<th>Last Price</th>
						<th>Quantity</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>NSE</td>
						<td>SBIN</td>
						<td>319.15</td>
						<td>569874</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-danger btn-remove" type="button" ><i class="glyphicon glyphicon-trash"></i></button>
						</td>
					</tr>
					<tr>
						<td>BSE</td>
						<td>HINDALCO</td>
						<td>320</td>
						<td>623422</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-danger btn-remove" type="button" ><i class="glyphicon glyphicon-trash"></i></button>
						</td>
					</tr>
					<tr>
						<td>NSE</td>
						<td>SBIN</td>
						<td>319.15</td>
						<td>569874</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-danger btn-remove" type="button" ><i class="glyphicon glyphicon-trash"></i></button>
						</td>
					</tr>
					<tr>
						<td>BSE</td>
						<td>HINDALCO</td>
						<td>320</td>
						<td>623422</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-danger btn-remove" type="button" ><i class="glyphicon glyphicon-trash"></i></button>
						</td>
					</tr>
					<tr>
						<td>NSE</td>
						<td>SBIN</td>
						<td>319.15</td>
						<td>569874</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-danger btn-remove" type="button" ><i class="glyphicon glyphicon-trash"></i></button>
						</td>
					</tr>
					<tr>
						<td colspan="5">
							<a href="#">View Full WatchList</a>
						</td>
					</tr>
				</tbody>
			</table>
        </div>
    </div>
    <!-- /.row -->
	  
	<!-- .row -->
    <div class="row">
		<div class="col-lg-12">
			<h3>Most Active Stocks</h3>
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>Market</th>
						<th>Stock</th>
						<th>Last Price</th>
						<th>Quantity</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>NSE</td>
						<td>SBIN</td>
						<td>319.15</td>
						<td>569874</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-info" type="button" ><i class="glyphicon glyphicon-info-sign"></i></button>
						</td>
					</tr>
					<tr>
						<td>BSE</td>
						<td>HINDALCO</td>
						<td>320</td>
						<td>623422</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-info" type="button" ><i class="glyphicon glyphicon-info-sign"></i></button>
						</td>
					</tr>
					<tr>
						<td>NSE</td>
						<td>SBIN</td>
						<td>319.15</td>
						<td>569874</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-info" type="button" ><i class="glyphicon glyphicon-info-sign"></i></button>
						</td>
					</tr>
					<tr>
						<td>BSE</td>
						<td>HINDALCO</td>
						<td>320</td>
						<td>623422</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-info" type="button" ><i class="glyphicon glyphicon-info-sign"></i></button>
						</td>
					</tr>
					<tr>
						<td>NSE</td>
						<td>SBIN</td>
						<td>319.15</td>
						<td>569874</td>
						<td><button class="btn btn-success btn-add" type="button" >Add</button>
							<button class="btn btn-info" type="button" ><i class="glyphicon glyphicon-info-sign"></i></button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
    </div>
    <!-- /.row -->

	</div>
    <!-- /.container -->

    <?php require 'includes/footer.php'?>
    <?php require 'includes/foot.php'?>

  </body>

</html>
