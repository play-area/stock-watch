<?php

require "../config/dbcon.php";

define('BANK_NIFTY_QUERY', 'SELECT * from banknifty_daily Order By recorddate ASC');

/* Getting Results from database and performing calculations */
function calculateOptions(){
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	/* create a prepared statement */
	$stmt = $conn->prepare(BANK_NIFTY_QUERY);

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
	echo("<b>Start Date &nbsp; : &nbsp;</b>".$queryResults[0]['recorddate']);
	echo("<b>&nbsp;&nbsp;End Date &nbsp; : &nbsp;</b>".$queryResults[$i-1]['recorddate']."<br/>");
	calculateWeeklyPriceRange($queryResults);
}

/*Function to calculate the price range of Bank Nifty for last 4 days of week, considering Monday open to Thursday close*/
function calculateWeeklyPriceRange($queryResults){
	$startDate=null;
	$endDate=null;
	$i=0;
	$j=0;
	foreach($queryResults as $result){
		$i=getDayOfWeek($result['dayofweek']);
		//To check start of new week and reset everything
		$next = next($queryResults);
		if($i<$j || $next ==null || !isset($next)){
			$weeklyResults[] = array('startDate' => $startDate,
			'endDate' => $endDate,
			'open'=>$open,
			'close'=>$close,
			'high'=>$high,
			'low'=>$low);
			$startDate=null;
			$endDate=null;
		}
		$j=$i;
		//If day is monday or tuesday or wednesday or thursday
		if($i==1 || $i==2 || $i==3 || $i==4){
			if($startDate ==null){
				$startDate=$result['recorddate'];
				$open=$result['open'];
				$high=$result['high'];
				$low=$result['low'];
			}
			if ($startDate !=null && getDayDifference($startDate,$result['recorddate'])<=4 && $i<=4){
				$endDate=$result['recorddate'];
				$close=$result['close'];
			}
			//To find highest and lowest prices
			if($result['high']>$high){
				$high=$result['high'];
			}
			if($result['low']<$low){
				$low=$result['low'];
			}
		}
	}
	echo("</br>Weeks on which <b>BankNifty</b> moved more than a <b>800 points </b> between Monday and Thursday</br></br>");
	echo("<table class='table table-striped'><tr><th>Start Date</th><th>End Date</th><th>Days</th><th>Max Up</th><th>Min Down</th><th>Open - Close</th></tr>");
	foreach($weeklyResults as $weekResult){
		$maxUp=$weekResult['high']-$weekResult['open'];
		$maxDown=$weekResult['low']-$weekResult['open'];
		$priceDiff=abs($weekResult['open']-$weekResult['close']);
		if(abs($maxUp)>800 || abs($maxDown)>800){
			echo("<tr><td>".$weekResult['startDate']."</td><td>".$weekResult['endDate']."</td><td>".getDayDifference($weekResult['startDate'],$weekResult['endDate'])."</td><td>".$maxUp."</td><td>".$maxDown."</td><td>".$priceDiff."</td></tr>");
		}
	}
	echo("</table>");
	
}

/* Function to check day of week and return the numeric representation for that day*/
function getDayOfWeek($dayOfWeek){
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

function getDayDifference($stDate,$edDate,$tz = "Asia/Kolkata"){
	$startDate = new DateTime($stDate, new DateTimeZone($tz));
	$endDate = new DateTime($edDate, new DateTimeZone($tz));
	$interval = $startDate->diff($endDate);
	return $interval->format('%R%a days');
}

