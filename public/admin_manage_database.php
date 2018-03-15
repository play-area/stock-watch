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
			<form class="update-database-form" method="post" onsubmit="updateDatabase()">
				<fieldset>
					<div class="form-group">
						<label class="control-label font-weight-600">Data Source</label>
						<div class="selectContainer border">
							<select id="data-source" name="data-source" class="form-control">
								<option value="quandl">Quandl</option>
								<option value="nse">Nse</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label font-weight-600">Watch List</label>
						<div class="selectContainer border">
							<select id="watchlist" name="watchlist" class="form-control">
								<option value="liquid-options">Liquid Options</option>
								<option value="f&o">FO</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label font-weight-600">Time Frame</label>
						<div class="selectContainer border">
							<select id="time-frame" name="time-frame" class="form-control">
								<option value="daily">Daily</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label font-weight-600">Update Type</label><br/>
						<input type="radio" name="update-type" value="full" checked onclick="showHideUpdateDatabaseDates(this)"/> Full Update
						<input type="radio" name="update-type" value="partial" onclick="showHideUpdateDatabaseDates(this)"/>Partial Update
					</div>
					<div class="form-group" style="display:none">
						<label for="startdate" class="font-weight-600">Start Date</label>
						<input id="startdate" name="startdate" type="date" placeholder="mm/dd/yyyy" />
					</div>
					<div class="form-group"style="display:none" >
						<label for="enddate" class="font-weight-600">End Date</label>
						<input id="enddate" name="enddate" type="date" placeholder="mm/dd/yyyy"/>
					</div>
					<div class="form-group">
						<input class="btn btn-success" type="submit" value="Update"/>
					</div>
					<div class="form-group">
						<input type="hidden" name="act" value="update-database"/>
					</div>
				</fieldset>
			</form>
        </div>
		
        <div class="col-lg-8 update-results">
			<h4>Update Database Logs</h4>
			<div id="results-div"></div>
			<div id="logs-message">Please check the full logs <a href="admin_database_logs.php">here</a></div>
			<div id="onload-results"></div>
        </div>
    </div>
    <!-- /.row -->
	
	<div class="row-separator"></div>
	
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
						<input class="btn btn-success" type="submit" value="Update"/>
					</div>
					<div class="form-group">
						<input type="hidden" name="act" value="update-calculations"/>
					</div>
				</fieldset>
			</form>
        </div>
		<div class="col-lg-8">
			<h4>Calculation Logs</h4>
			Please check the full logs <a href="admin_database_logs.php">here</a>
		</div>
    </div>
    <!-- /.row -->
	
	<!-- Results Modal -->
	<!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Large Modal</button>-->

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog" style="display:none">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Modal Header</h4>
		</div>
		<div class="modal-body">
		  <p>This is a large modal.</p>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
	</div>
	  
	</div>
    <!-- /.container -->

    <?php require 'includes/footer.php'?>
    <?php require 'includes/foot.php'?>

  </body>

</html>
