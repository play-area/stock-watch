<!DOCTYPE html>
<html lang="en">

  <head>

    <?php require 'includes/head.php'?>

  </head>

  <body>

    <?php require 'includes/navigation.php'?>
    
    <!-- Page Content -->
    <div class="container">

      <!-- Page Heading/Breadcrumbs -->
      <h3 class="mt-4 mb-3">Screeners</h3>

      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Home</a>
        </li>
        <li class="breadcrumb-item active">Screeners</li>
      </ol>

      <!-- Image Header -->
      <!-- <img class="img-fluid rounded mb-4" src="images/backgrounds/1200X300.png" alt="">-->

      <!-- Marketing Icons Section -->
      <div class="row">
        <div class="col-lg-6 mb-6">
          <div class="card h-100">
            <h4 class="card-header">Bullish Screener 1</h4>
            <div class="card-body">
				<ul class="list-group">
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > Percentage Change > 1%</li>
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > Candle > Avg Candle</li>
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > Candle Body > 1/2 Candle Height</li>
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > Volume > Avg Volume</li>
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > 20 MA > 50 MA</li>
				</ul>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-success">Search</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-6">
          <div class="card h-100">
            <h4 class="card-header">Bearish Screener 1</h4>
            <div class="card-body">
				<ul class="list-group">
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > Percentage Change < -1%</li>
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > Candle > Avg Candle</li>
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > Candle Body > 1/2 Candle Height</li>
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > Volume > Avg Volume</li>
					<li class="list-group-item"><input type="checkbox" id="defaultCheck1" checked > 20 MA < 50 MA</li>
				</ul>
            </div>
            <div class="card-footer">
              <a href="#" class="btn btn-success">Search</a>
            </div>
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
