<!DOCTYPE html>
<html lang="en">

  <head>
	
	<?php require 'includes/head.php'?>
    
  </head>

  <body>

    <?php require 'includes/navigation.php'?>
    
    <!-- Page Content -->
    <div class="container">
	
	<h3 class="my-4">Manage Database</h3>
	
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
        <div class="col-lg-4">
			<h4>Update Database</h4>
			<form class="stock-search-form" method="post" action="../app/controllers/updateDatabaseController.php">
				<fieldset>
					<div class="form-group">
						<label for="startdate" class="font-weight-600">Start Date:</label>
						<input id="startdate" name="startdate" type="date" placeholder="mm/dd/yyyy" required />
					</div>
					<div class="form-group">
						<label for="enddate" class="font-weight-600">End Date:</label>
						<input id="enddate" name="enddate" type="date" placeholder="mm/dd/yyyy"/>
					</div>
					<div class="form-group">
						<input class="btn btn-success" type="submit"/>
					</div
				</fieldset>
			</form>
        </div>
		
        <div class="col-lg-8">
			<h4>Database Update Logs</h4>
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
			<h4>Perform Caluclations</h4>
			<form class="calculations-form" method="post" onsubmit="updateCalculations()">
				<fieldset>
					<div class="form-group">
						<label for="calculationdate" class="font-weight-600">Date</label>
						<input id="calculationdate" name="calculationdate" type="date" value="2018-01-02" required />
					</div>
					<div class="form-group">
						<input type="checkbox" class="calculation-checkbox" id="avgcandle50" checked />
						<label for="defaultCheck1" class="font-weight-600">Avg Candle 50</label>
					</div>
					<div class="form-group">
						<input type="checkbox" class="calculation-checkbox" id="avgvolume50" checked />
						<label for="defaultCheck1" class="font-weight-600">Avg Volume 50</label>
					</div>
					<div class="form-group">
						<input type="checkbox" class="calculation-checkbox" id="ma20" checked />
						<label for="defaultCheck1" class="font-weight-600">MA 20</label>
					</div>
					<div class="form-group">
						<input type="checkbox" class="calculation-checkbox" id="ma50" checked />
						<label for="defaultCheck1" class="font-weight-600">MA 50</label>
					</div>
					<div class="form-group">
						<button class="btn btn-success" type="submit">Update</button>
					</div>
				</fieldset>
			</form>
        </div>
		<div class="col-lg-8">
			<h4>Calculation Logs</h4>
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
