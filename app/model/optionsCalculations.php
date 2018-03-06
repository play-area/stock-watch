<?php

require "../config/dbcon.php";

define('DAILY_TIMEFRAME_QUERY', 'SELECT * from ? Order By recorddate ASC');

//Function to get the Strikes at various Standard Deviations
function getStrikes($symbol,$spotPrice,$dailyReturnDuration,$dailyReturn,$dailyVolatilityDuration,$dailyVolatility,$daysToExp){
	if($dailyReturnDuration!="manual"){
		$dailyReturn = getDailyReturnVolatility($symbol,$dailyReturnDuration,"return");
		echo("<span class='font-weight-600'>Daily Return(%) = </span>$dailyReturn <br/>");
	}
	if($dailyVolatilityDuration!="manual"){
		$dailyVolatility = getDailyReturnVolatility($symbol,$dailyVolatilityDuration,"volatility");
		echo("<span class='font-weight-600'>Daily Volatility(%)= </span>$dailyVolatility <br/><br/>");
	}
	
	$upperOneSD=	$spotPrice*(1+ ($dailyReturn*$daysToExp/100) + ($dailyVolatility*sqrt($daysToExp)/100));
	$lowerOneSD=	$spotPrice*(1+($dailyReturn*$daysToExp/100) - ($dailyVolatility*sqrt($daysToExp)/100));
	
	$upperTwoSD=	$spotPrice*(1+($dailyReturn*$daysToExp/100) + (2*$dailyVolatility*sqrt($daysToExp)/100));
	$lowerTwoSD=	$spotPrice*(1+($dailyReturn*$daysToExp/100) - (2*$dailyVolatility*sqrt($daysToExp)/100));
	
	$upperThreeSD=	$spotPrice*(1+($dailyReturn*$daysToExp/100) + (3*$dailyVolatility*sqrt($daysToExp)/100));
	$lowerThreeSD=	$spotPrice*(1+($dailyReturn*$daysToExp/100) - (3*$dailyVolatility*sqrt($daysToExp)/100));
	
	echo("<table class='table table-striped'><tr><th>Standard Deviation</th><th>Upper Strike Price</th><th>Lower Strike Price</th></tr>");
	echo("<tr><td> First SD (68% probability)</td><td>$upperOneSD</td><td>$lowerOneSD</td></tr>");
	echo("<tr><td> Second SD (95% probability)</td><td>$upperTwoSD</td><td>$lowerTwoSD</td></tr>");
	echo("<tr><td> Third SD (99.7% probability)</td><td>$upperThreeSD</td><td>$lowerThreeSD</td></tr>");
	echo("</table>");
}

//Function to get the Daily Returns in percentage for a particular symbol
//Assumption being that there are 250 trading days in a year(12 months). So 6 months is approximately equal to 125 days
function getDailyReturnVolatility($symbol,$dailyReturnDuration,$toCalculate){
	$queryResults=getDatabaseRecords($symbol);
	$i=0;
	$dailyReturnsPercentage[]=array();
	if(empty($queryResults)){
		echo("No Result to Display, data not present.");
		return;
	}
	if($dailyReturnDuration==="6"){
		$n=125;
	}
	if($dailyReturnDuration==="12"){
		$n=250;
	}
	//Getting the last n records from the array.
	$resultsArray = array_slice($queryResults, -$n);

	foreach($resultsArray as $result){
		$nextRecord = $resultsArray[$i+1<count($resultsArray)?$i+1:count($resultsArray)-1];
		if($i+1<count($resultsArray)){
			$dailyReturnsPercentage[$i++]=($nextRecord['close']-$result['close'])*100/$result['close'];
		}
	}
	if($toCalculate==="return"){
		$averageDailyReturn = array_sum($dailyReturnsPercentage)/count($dailyReturnsPercentage);
		return $averageDailyReturn;
	}else if($toCalculate==="volatility"){
		$averageDailyVolatility = getStandardDeviation($dailyReturnsPercentage);
		return $averageDailyVolatility;
	}
}

//Function to calculate Standard Deviation
function getStandardDeviation($a)
{
  //variable and initializations
  $the_standard_deviation = 0.0;
  $the_variance = 0.0;
  $the_mean = 0.0;
  $the_array_sum = array_sum($a); //sum the elements
  $number_elements = count($a); //count the number of elements

  //calculate the mean
  $the_mean = $the_array_sum / $number_elements;

  //calculate the variance
  for ($i = 0; $i < $number_elements; $i++)
  {
    //sum the array
    $the_variance = $the_variance + ($a[$i] - $the_mean) * ($a[$i] - $the_mean);
  }

  $the_variance = $the_variance / $number_elements;

  //calculate the standard deviation
  $the_standard_deviation = pow( $the_variance, 0.5);

  //return the variance
  return $the_standard_deviation;
}

/*Function to calculate the Monthly Price Range*/
function getMonthlyPriceRange($symbol,$lowerPrice=0,$upperPrice=0){
	$queryResults=getDatabaseRecords($symbol);
	if(empty($queryResults)){
		echo("No Result to Display, data not present.");
		return;
	}
	echo("<b>Symbol : </b>".strtoupper($symbol)."&nbsp;&nbsp;");
	echo("<b>Start Date &nbsp; : &nbsp;</b>".$queryResults[0]['recorddate']);
	echo("<b>&nbsp;&nbsp;End Date &nbsp; : &nbsp;</b>".$queryResults[count($queryResults)-1]['recorddate']."<br/>");
	
	$startDate=null;
	$endDate=null;
	$high=0;
	$low=0;
	$open=0;
	$close=0;
	$i=0;
	
	foreach($queryResults as $result){
		$todaysDate = new DateTime($result['recorddate'], new DateTimeZone("Asia/Kolkata"));
		$nextRecord = $queryResults[$i+1<count($queryResults)?$i+1:count($queryResults)-1];
		$tomorrowsDate = new DateTime($nextRecord['recorddate'], new DateTimeZone("Asia/Kolkata"));
		
		//To check start of calculation period of the month
		if($startDate==null){
			$startDate=$result['recorddate'];
			$currentMonth=$todaysDate->format('m');
			$open=$result['open'];
			$high=$result['high'];
			$low=$result['low'];
		}
		//To calculate High and Low
		if($result['high']>$high){
			$high=$result['high'];
		}
		if($result['low']<$low){
			$low=$result['low'];
		}
		//To get end of calculation period for the month.
		if($currentMonth != $tomorrowsDate->format('m') || count($queryResults)==$i+1){
			$endDate=$result['recorddate'];
			$close=$result['close'];
			
			$monthlyResults[] = array('startDate' => $startDate,
			'endDate' => $endDate,
			'open'=>$open,
			'close'=>$close,
			'high'=>$high,
			'low'=>$low);
			
			$startDate=null;
			$endDate=null;
		}
		$i++;
	}
	//Printing the results
	$k=1;
	echo("</br>Months on which <b>".strtoupper($symbol)."</b> traded below<b>$lowerPrice</b> or traded above <b>$upperPrice</b></br></br>");
	echo("<table class='table table-striped'><tr><th>Sl No.</th><th>Start Date</th><th>End Date</th><th>Days</th><th>Month's High</th><th>Month's Low</th><th>Open - Close</th></tr>");
	foreach($monthlyResults as $monthResult){
		$maxUp=$monthResult['high']-$monthResult['open'];
		$maxDown=$monthResult['low']-$monthResult['open'];
		$priceDiff=abs($monthResult['open']-$monthResult['close']);
		if($maxUp>=$upperPrice || $maxDown<=$lowerPrice){
			echo("<tr><td>".$k."</td><td>".$monthResult['startDate']."</td><td>".$monthResult['endDate']."</td><td>".getDayDifference($monthResult['startDate'],$monthResult['endDate'])."</td><td>".$maxUp."</td><td>".$maxDown."</td><td>".$priceDiff."</td></tr>");
			$k++;
		}
	}
	echo("</table>");	
}

/*Function to calculate the Weekly Price Range*/
function getWeeklyPriceRange($symbol,$lowerPrice=0,$upperPrice=0,$startDay,$endDay){
	$queryResults=getDatabaseRecords($symbol);
	if(empty($queryResults)){
		echo("No Result to Display, data not present.");
		return;
	}
	echo("<b>Symbol : </b>".strtoupper($symbol)."&nbsp;&nbsp;");
	echo("<b>Start Date &nbsp; : &nbsp;</b>".$queryResults[0]['recorddate']);
	echo("<b>&nbsp;&nbsp;End Date &nbsp; : &nbsp;</b>".$queryResults[count($queryResults)-1]['recorddate']."<br/>");
	
	$startDate=null;
	$endDate=null;
	$high=0;
	$low=0;
	$open=0;
	$close=0;
	$dayNo=0;
	$i=0;
	
	//To get the difference between start day and end day.
	if(getDayNumber($startDay)<=getDayNumber($endDay)){
		$dayCount=getDayNumber($endDay)-getDayNumber($startDay) +1;
	}else if(getDayNumber($startDay)>getDayNumber($endDay)){
		$dayCount=7+ getDayNumber($endDay)-getDayNumber($startDay) +1;
	}
	
	foreach($queryResults as $result){
		$dayNo=getDayNumber($result['dayofweek']);
		$prevRecord=$queryResults[$i-1>0?$i-1:0];
		$nextRecord=$queryResults[$i+1<count($queryResults)?$i+1:count($queryResults)-1];
				
		//To check start of calculation period of the week
		if($dayNo==getDayNumber($startDay) ){
			$startDate=$result['recorddate'];
			$open=$result['open'];
			$high=$result['high'];
			$low=$result['low'];
		}
		//To calculate High and Low
		if($result['high']>$high){
			$high=$result['high'];
		}
		if($result['low']<$low){
			$low=$result['low'];
		}
		//To get end of calculation period for the week.
		if($startDate !=null && ($dayNo==getDayNumber($endDay) || getDayDifference($startDate,$nextRecord['recorddate']) >$dayCount)){
			$endDate=$result['recorddate'];
			$close=$result['close'];
			
			$weeklyResults[] = array('startDate' => $startDate,
			'endDate' => $endDate,
			'open'=>$open,
			'close'=>$close,
			'high'=>$high,
			'low'=>$low);
			
			$startDate=null;
			$endDate=null;
		}
		$i++;
	}
	
	//Printing the results
	$k=1;
	echo("</br>Weeks on which <b>".strtoupper($symbol)."</b> traded below<b>$lowerPrice</b> or traded above <b>$upperPrice</b> between $startDay and $endDay</br></br>");
	echo("<table class='table table-striped'><tr><th>Sl No.</th><th>Start Date</th><th>End Date</th><th>Days</th><th>Week's High</th><th>Week's Low</th><th>Open - Close</th></tr>");
	foreach($weeklyResults as $weekResult){
		$maxUp=$weekResult['high']-$weekResult['open'];
		$maxDown=$weekResult['low']-$weekResult['open'];
		$priceDiff=abs($weekResult['open']-$weekResult['close']);
		if($maxUp>=$upperPrice || $maxDown<=$lowerPrice){
			echo("<tr><td>".$k."</td><td>".$weekResult['startDate']."</td><td>".$weekResult['endDate']."</td><td>".getDayDifference($weekResult['startDate'],$weekResult['endDate'])."</td><td>".$maxUp."</td><td>".$maxDown."</td><td>".$priceDiff."</td></tr>");
			$k++;
		}
	}
	echo("</table>");
}

//Function to Get Database Records
function getDatabaseRecords($symbol){
	
	$tableName="daily_".$symbol;
	$dailyTimeframeQuery="SELECT * from ".$tableName." Order By recorddate ASC";
	$queryResults=null;
	
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	/* create a prepared statement */
	$stmt = $conn->prepare($dailyTimeframeQuery);
	
    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($recorddate,$dayofweek,$open,$high,$low,$close,$volume,$turnover);
	$i=0;
	while ($stmt->fetch()) {
		$queryResults[] = array('recorddate' => $recorddate,
			'dayofweek' => $dayofweek,
			'open' => $open,
			'high' => $high,
			'low' => $low,
			'close' => $close,
			'volume' => $volume,
			'turnover'=>$turnover);
		$i++;
	}
	$stmt->close();
	$conn->close();
	
	return $queryResults;
}

/* Function to get the difference in no. of days between two dates */
function getDayDifference($stDate,$edDate,$tz = "Asia/Kolkata"){
	$startDate = new DateTime($stDate, new DateTimeZone($tz));
	$endDate = new DateTime($edDate, new DateTimeZone($tz));
	$interval = $startDate->diff($endDate);
	return (int)$interval->format('%R%a days') + 1;
}

/* Function to check day of week and return the numeric representation for that day*/
function getDayNumber($dayOfWeek){
	switch ($dayOfWeek){
		case "Monday":
			return 1;
			break;
		case "Tuesday":
			return 2;
			break;
		case "Wednesday":
			return 3;
			break;
		case "Thursday":
			return 4;
			break;
		case "Friday":
			return 5;
			break;
		case "Saturday":
			return 6;
			break;
		case "Sunday":
			return 7;
			break;
		default:
			echo "Day not Present";
	}
}

