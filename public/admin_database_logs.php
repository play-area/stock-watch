<!DOCTYPE html>
<html lang="en">

  <head>
	
	<?php require 'includes/head.php'?>
    
  </head>

  <body>

    <?php require 'includes/navigation.php'?>
    
    <!-- Page Content -->
    <div class="container">
	
	<h3 class="my-4">Database Logs</h3>
	
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Home</a>
		</li>
		<li class="breadcrumb-item active">Manage</li>
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
        <div class="col-lg-8">
			<h4>Database Update Logs</h4>
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>Symbol</th>
						<th>Dates not present</th>
						<th>Extra Dates present</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>IDEA</td>
						<td>28th Feb 2015, 19th July 2017, 18th Jan 2018</td>
						<td>21st Aug 2017, 25th Dec 2018</td>
					</tr>
					<tr>
						<td>SBI</td>
						<td>28th Feb 2015, 19th July 2017, 18th Jan 2018</td>
						<td>21st Aug 2017, 25th Dec 2018</td>
					</tr>
					<tr>
						<td>VEDL</td>
						<td>28th Feb 2015, 19th July 2017, 18th Jan 2018</td>
						<td>21st Aug 2017, 25th Dec 2018</td>
					</tr>
					<tr>
						<td>HINDALCO</td>
						<td>28th Feb 2015, 19th July 2017, 18th Jan 2018</td>
						<td>21st Aug 2017, 25th Dec 2018</td>
					</tr>
					<tr>
						<td>TATAMOTORS</td>
						<td>28th Feb 2015, 19th July 2017, 18th Jan 2018</td>
						<td>21st Aug 2017, 25th Dec 2018</td>
					</tr>
					<tr>
						<td colspan="3">
							<a href="#">View Full Logs</a>
						</td>
					</tr>
				</tbody>
			</table>
        </div>
    </div>
    <!-- /.row -->
	
	</br><h4>Full Logs</h4></br>
	
	<!-- .row -->
    <div class="row">
        <div class="col-lg-6">
			<h5>Daily Table</h5>
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>Symbol</th>
						<th>Total Records</th>
						<th>Missing Records</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>IDEA</td>
						<td>1200</td>
						<td>0</td>
					</tr>
					<tr>
						<td>SBI</td>
						<td>1198</td>
						<td>2</td>
					</tr>
					<tr>
						<td>IDEA</td>
						<td>1200</td>
						<td>0</td>
					</tr>
					<tr>
						<td>SBI</td>
						<td>1198</td>
						<td>2</td>
					</tr>
					<tr>
						<td>IDEA</td>
						<td>1200</td>
						<td>0</td>
					</tr>
					<tr>
						<td>SBI</td>
						<td>1198</td>
						<td>2</td>
					</tr>
					<tr>
						<td colspan="3">
							<a href="#">View Full Logs</a>
						</td>
					</tr>
				</tbody>
			</table>
        </div>
		<div class="col-lg-6">
			<h5>Calculations Table</h5>
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>Symbol</th>
						<th>Total Records</th>
						<th>Missing Records</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>IDEA</td>
						<td>250</td>
						<td>0</td>
					</tr>
					<tr>
						<td>SBI</td>
						<td>248</td>
						<td>2</td>
					</tr>
					<tr>
						<td>IDEA</td>
						<td>250</td>
						<td>0</td>
					</tr>
					<tr>
						<td>SBI</td>
						<td>248</td>
						<td>2</td>
					</tr>
					<tr>
						<td>IDEA</td>
						<td>250</td>
						<td>0</td>
					</tr>
					<tr>
						<td>SBI</td>
						<td>248</td>
						<td>2</td>
					</tr>
					<tr>
						<td colspan="3">
							<a href="#">View Full Logs</a>
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
