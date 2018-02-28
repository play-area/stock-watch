<!DOCTYPE html>
<html lang="en">

  <head>
	
	<?php require 'includes/head.php'?>
    
  </head>

  <body>

    <?php require 'includes/navigation.php'?>
    
    <!-- Page Content -->
    <div class="container">
	
	<h3 class="my-4">Option Stats</h3>
	
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
			<h4>Strike Price Calculator</h4>
			<form class="options-form" method="post" onsubmit="calculateOptions()">
				<fieldset>
					<div class="form-group">
						<label class="control-label"><b>Symbol</b></label>
						<div class="selectContainer border">
							<select id="symbol" name="symbol" class="form-control">
								<option value="banknifty">BANK NIFTY</option>
								<option value="nifty">NIFTY</option>
								<option value="usdinr">USD/INR</option>
								<option value="sbin">SBIN</option>
								<option value="reliance">RELIANCE</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label"><b>Time Period</b></label>
						<div class="selectContainer border">
							<select id="time-period" name="time-period" class="form-control">
								<option value="Monthly">Monthly</option>
								<option value="Weekly">Weekly</option>
							</select>
						</div>
					</div> 
					<div class="form-group">
						<label class="control-label"><b>Price Variation</b></label></br>
						Lower Price Range <=<input type="text" class="form-control" name="lower-price" id="lower-price"></br>
						Upper Price Range >=<input type="text" class="form-control" name="upper-price" id="upper-price">
					</div>
					<div class="form-group" style="display:none">
						<label class="control-label"><b>Start Day</b></label>
						<div class="selectContainer border">
							<select id="start-day" name="start-day" class="form-control">
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
							</select>
						</div>
					</div>
					<div class="form-group" style="display:none">
						<label class="control-label"><b>End Day</b></label>
						<div class="selectContainer border">
							<select id ="end-day" name="end-day" class="form-control">
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<input class="btn btn-success" type="submit" value="Calculate"></button>
					</div>
				</fieldset>
			</form>
        </div>
		<div class="col-lg-8 results">
			<h4>Result</h4>
			<div>
				Getting Stats.....
			</div>
		</div>
    </div>
    <!-- /.row -->
	
	<div class="row-separator"></div>
	
	<!-- .row -->
    <div class="row">
        <div class="col-lg-4">
			<h4>Symbol Specific Stats</h4>
			<form class="options-form" method="post" onsubmit="calculateOptions()">
				<fieldset>
					<div class="form-group">
						<label class="control-label"><b>Symbol</b></label>
						<div class="selectContainer border">
							<select id="symbol" name="symbol" class="form-control">
								<option value="banknifty">BANK NIFTY</option>
								<option value="nifty">NIFTY</option>
								<option value="usdinr">USD/INR</option>
								<option value="sbin">SBIN</option>
								<option value="reliance">RELIANCE</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label"><b>Time Period</b></label>
						<div class="selectContainer border">
							<select id="time-period" name="time-period" class="form-control">
								<option value="Monthly">Monthly</option>
								<option value="Weekly">Weekly</option>
							</select>
						</div>
					</div> 
					<div class="form-group">
						<label class="control-label"><b>Price Variation</b></label></br>
						Lower Price Range <=<input type="text" class="form-control" name="lower-price" id="lower-price"></br>
						Upper Price Range >=<input type="text" class="form-control" name="upper-price" id="upper-price">
					</div>
					<div class="form-group" style="display:none">
						<label class="control-label"><b>Start Day</b></label>
						<div class="selectContainer border">
							<select id="start-day" name="start-day" class="form-control">
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
							</select>
						</div>
					</div>
					<div class="form-group" style="display:none">
						<label class="control-label"><b>End Day</b></label>
						<div class="selectContainer border">
							<select id ="end-day" name="end-day" class="form-control">
								<option value="Monday">Monday</option>
								<option value="Tuesday">Tuesday</option>
								<option value="Wednesday">Wednesday</option>
								<option value="Thursday">Thursday</option>
								<option value="Friday">Friday</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<input class="btn btn-success" type="submit" value="Calculate"></button>
					</div>
				</fieldset>
			</form>
        </div>
		<div class="col-lg-8 results">
			<h4>Result</h4>
			<div>
				Getting Stats.....
			</div>
		</div>
    </div>
    <!-- /.row -->
	  
	</div>
    <!-- /.container -->

    <?php require 'includes/footer.php'?>
    <?php require 'includes/foot.php'?>

  </body>

</html>
