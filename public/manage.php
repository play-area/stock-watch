<!DOCTYPE html>
<html lang="en">

  <head>
	
	<?php require 'includes/head.php'?>
    
  </head>

  <body>

    <?php require 'includes/navigation.php'?>
    
    <!-- Page Content -->
    <div class="container">
	
	<h2 class="my-4">Manage Database</h2>
	
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="index.php">Home</a>
		</li>
		<li class="breadcrumb-item active">Manage</li>
	</ol>
	
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
        <div class="col-lg-4">
			<h3>Update Database</h3>
			<form class="stock-search-form" method="post" action="../app/controllers/updateDatabaseController.php">
				<div class="form-group">
					<label for="startdate">Start Date:</label>
					<input id="startdate" name="startdate" type="date" placeholder="mm/dd/yyyy" required />
				</div>
				<div class="form-group">
					<label for="enddate">End Date:</label>
					<input id="enddate" name="enddate" type="date" placeholder="mm/dd/yyyy"/>
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Update</button>
				</div>
			</form>
        </div>
		
        <div class="col-lg-8">
			<h3>Database Update Logs</h3>
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Log</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>12/10/2017</td>
						<td>Bhavcopy file for 12/10/2017 updated successfully.</td>
					</tr>
					<tr>
						<td>12/10/2017</td>
						<td>Bhavcopy file for 12/10/2017 updated successfully.</td>
					</tr>
					<tr>
						<td>12/10/2017</td>
						<td>Bhavcopy file for 12/10/2017 updated successfully.</td>
					</tr>
					<tr>
						<td>12/10/2017</td>
						<td>Bhavcopy file for 12/10/2017 updated successfully.</td>
					</tr>
					<tr>
						<td>12/10/2017</td>
						<td>Bhavcopy file for 12/10/2017 updated successfully.</td>
					</tr>
					<tr>
						<td colspan="5">
							<a href="#">View Full Logs</a>
						</td>
					</tr>
				</tbody>
			</table>
        </div>
    </div>
    <!-- /.row -->
	
	<!-- .row -->
    <div class="row">
        <div class="col-lg-4">
			<h3>Perform Caluclations</h3>
			<form class="calculations-form" method="post" onsubmit="updateCalculations()">
				<div class="form-group">
					<label for="calculationdate">Date</label>
					<input id="calculationdate" name="calculationdate" type="date" placeholder="mm/dd/yyyy" required />
				</div>
				<div class="form-group">
					<input type="checkbox" class="calculation-checkbox" id="avgcandle50" checked />
					<label for="defaultCheck1">Avg Candle 50</label>
				</div>
				<div class="form-group">
					<input type="checkbox" class="calculation-checkbox" id="avgvolume50" checked />
					<label for="defaultCheck1">Avg Volume 50</label>
				</div>
				<div class="form-group">
					<input type="checkbox" class="calculation-checkbox" id="ma20" checked />
					<label for="defaultCheck1">MA 20</label>
				</div>
				<div class="form-group">
					<input type="checkbox" class="calculation-checkbox" id="ma50" checked />
					<label for="defaultCheck1">MA 50</label>
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Update</button>
				</div>
			</form>
        </div>
		<div class="col-lg-8">
			<h3>Calculation Logs</h3>
			<table class="table table-hover table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Log</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>12/10/2017</td>
						<td>Calculations done successfully for 12/10/2017</td>
					</tr>
					<tr>
						<td>12/10/2017</td>
						<td>Calculations done successfully for 12/10/2017</td>
					</tr>
					<tr>
						<td>12/10/2017</td>
						<td>Calculations done successfully for 12/10/2017</td>
					</tr>
					<tr>
						<td>12/10/2017</td>
						<td>Calculations done successfully for 12/10/2017</td>
					</tr>
					<tr>
						<td>12/10/2017</td>
						<td>Calculations done successfully for 12/10/2017</td>
					</tr>
					<tr>
						<td colspan="5">
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
