<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Stock Watch</title>

    <!-- Bootstrap core CSS -->
	<link href="../vendor/bootstrap/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	
    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">

  </head>

  <body>
    <!-- Page Content -->
    <div class="container">
	
		<div class="row">
			<h2 class="my-4">Php Rest Webservice Calls</h2>
		
			<?php
			function callWebService($symbol){
				$apiKey = "5ARB0R48XFE3NC7A";
				$url = "https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=".$symbol."&interval=60min&apikey=".$apiKey;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); // To Prevent output to be displayed on screen
				$response = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // To get HTTP Code
				curl_close($ch);
				if($httpcode !='200'){
					// Then again make the webservice call, keep doing this till response for max 5 times
				}
				return $response;
			}
			$response =   callWebService('LUPIN');
			$resultJson = json_decode($response, true);
			
			echo("<br><h5>Symbol : </h5>".$resultJson['Meta Data']['2. Symbol']."</br>");
			echo ("<table class='table table-bordered table-striped'>");
				echo("<tr><th>Time</th><th>Open</th><th>High</th><th>Low</th><th>Close</th><th>Volume</th></tr>");
				echo ("<tr>");
					echo ("<td>3:00 PM IST</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 04:30:00']['1. open']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 04:30:00']['2. high']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 04:30:00']['3. low']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 04:30:00']['4. close']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 04:30:00']['5. volume']."</td>");
				echo ("</tr>");
				echo ("<tr>");
					echo ("<td>2:00 PM IST</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 03:30:00']['1. open']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 03:30:00']['2. high']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 03:30:00']['3. low']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 03:30:00']['4. close']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 03:30:00']['5. volume']."</td>");
				echo ("</tr>");
				echo ("<tr>");
					echo ("<td>1:00 PM IST</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 02:30:00']['1. open']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 02:30:00']['2. high']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 02:30:00']['3. low']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 02:30:00']['4. close']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 02:30:00']['5. volume']."</td>");
				echo ("</tr>");
				echo ("<tr>");
					echo ("<td>12:00 PM IST</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 01:30:00']['1. open']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 01:30:00']['2. high']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 01:30:00']['3. low']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 01:30:00']['4. close']."</td>");
					echo ("<td>".$resultJson['Time Series (60min)']['2018-01-05 01:30:00']['5. volume']."</td>");
				echo ("</tr>");
			echo ("</table>");
			?>
		</div>
	</div>
    <!-- Bootstrap core JavaScript -->,
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../js/common.js"></script>

  </body>

</html>
