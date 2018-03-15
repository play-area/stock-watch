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
			<form class="strikes-form" method="post" onsubmit="calculateStrikes()">
				<fieldset>
					<div class="form-group">
						<label class="control-label font-weight-600">Symbol</label>
						<div class="selectContainer border">
							<select id="symbol" name="symbol" class="form-control">
								<option value="banknifty">BANK NIFTY</option>
								<option value="nifty">NIFTY</option>
								<option value="usdinr">USD/INR</option>
								<option value="sbin">SBIN</option>
								<option value="reliance">RELIANCE</option>
								<option value="ashokley">ASHOKLEY</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label font-weight-600">Spot Price</label>
						<input type="text" class="form-control" name="spot-price" id="spot-price">
					</div>
					<div class="form-group">
						<label class="control-label font-weight-600">Daily Return(%)</label><br/>
						<input type="radio" name="daily-return" value="6" onclick="showHideManualEntry(this)"/> 6 months
						<input type="radio" name="daily-return" value="12" checked onclick="showHideManualEntry(this)"/>12 months
						<input type="radio" name="daily-return" value="manual" onclick="showHideManualEntry(this)"/>Custom<br/> 
						<input type="text" class="form-control" name="daily-return-manual" id="daily-return-manual" style="display:none"/>
					</div>
					<div class="form-group">
						<label class="control-label font-weight-600">Daily Volatility(%)</label><br/>
						<input type="radio" name="daily-volatility" value="6" checked onclick="showHideManualEntry(this)"/> 6 months
						<input type="radio" name="daily-volatility" value="12" onclick="showHideManualEntry(this)"/>12 months
						<input type="radio" name="daily-volatility" value="manual" onclick="showHideManualEntry(this)"/>Custom<br/> 
						<input type="text" class="form-control" name="daily-volatility-manual" id="daily-volatility-manual" style="display:none"/>
					</div>
					<div class="form-group">
						<label class="control-label font-weight-600">Days to Expiry<span class="font-weight-400">(Working Days)</span></label>
						<input type="text" class="form-control" name="days-to-expiry" id="days-to-expiry">
					</div>
					<div class="form-group">
						<input class="btn btn-success" type="submit" value="Calculate"/>
					</div>
					<div class="form-group">
						<input type="hidden" name="act" value="calculate-strikes"/>
					</div>
				</fieldset>
			</form>
        </div>
		<div class="col-lg-8 strike-results">
			<h4>Option Strikes</h4>
			<div>
				Getting Strikes.....
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>Standard Deviation</th>
							<th>Lower Price</th>
							<th>Upper Price</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1 SD</td>
							<td>129</td>
							<td>152</td>
						</tr>
						<tr>
							<td>2 SD</td>
							<td>129</td>
							<td>152</td>
						</tr>
						<tr>
							<td>3 SD</td>
							<td>129</td>
							<td>152</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
    </div>
    <!-- /.row -->
	
	<div class="row-separator"></div>
	
	<!-- .row -->
    <div class="row">
        <div class="col-lg-4">
			<h4>Symbol Specific Stats</h4>
			<form class="options-form" name="options-form" method="post" onsubmit="calculateStockStats()">
				<fieldset>
					<div class="form-group">
						<label class="control-label font-weight-600">Symbol</label>
						<div class="selectContainer border">
							<select id="symbol" name="symbol" class="form-control">
								<option value="banknifty">BANK NIFTY</option>
								<option value="nifty">NIFTY</option>
								<option value="usdinr">USD/INR</option>
								<option value="sbin">SBIN</option>
								<option value="reliance">RELIANCE</option>
								<option value="ashokley">ASHOKLEY</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label font-weight-600">Time Period</label>
						<div class="selectContainer border">
							<select id="time-period" name="time-period" class="form-control">
								<option value="Monthly">Monthly</option>
								<option value="Weekly">Weekly</option>
							</select>
						</div>
					</div> 
					<div class="form-group">
						<label class="control-label font-weight-600">Price Variation</label><br/>
						Lower Price Range <input type="text" class="form-control" name="lower-price" id="lower-price"><br/>
						Upper Price Range <input type="text" class="form-control" name="upper-price" id="upper-price">
					</div>
					<div class="form-group" style="display:none">
						<label class="control-label font-weight-600">Start Day</label>
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
						<label class="control-label font-weight-600">End Day</label>
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
						<input type="submit" class="btn btn-success" id="options-form-submit" name="options-form-submit"  value="Calculate"/>
					</div>
					<div class="form-group">
						<input type="hidden" name="act" value="calculate-stats"/>
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
