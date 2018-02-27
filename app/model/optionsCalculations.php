<?php

require "../config/dbcon.php";

define('DAILY_TIMEFRAME_QUERY', 'SELECT * from ? Order By recorddate ASC');

/*Function to calculate the Monthly Price Range*/
function getMonthlyPriceRange($symbol,$lowerPrice=0,$upperPrice=0){
	$queryResults=getDatabaseRecords($symbol);
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
		if($currentMonth != $tomorrowsDate->format('m')){
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
	//echo("</br>Weeks on which <b>BankNifty</b> moved more than a <b>1000 points </b> between $startDay and $endDay</br></br>");
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
	echo("</br>Weeks on which <b>BankNifty</b> moved more than a <b>1000 points </b> between $startDay and $endDay</br></br>");
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
	
	$tableName=$symbol."_daily";
	$dailyTimeframeQuery="SELECT * from ".$tableName." Order By recorddate ASC";
	
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

