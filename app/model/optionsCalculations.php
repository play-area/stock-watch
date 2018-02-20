<?php

require "../config/dbcon.php";

define('BANK_NIFTY_QUERY', 'SELECT * from banknifty_daily Order By recorddate DESC');

/* Getting Results from database and performing calculations */
function calculateOptions(){
	echo("Inside optionsCalcualtions.php");
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
	echo("Start Date =");
	//print_r($queryResults);
	/* If any holiday in between, then how to check prices between Friday and Thursday or between Monday and Thursday */
	/* To consider Monday Morning as base price and then calculate the Highest and Lowest Price from there till Thursday close*/
	/* To consider Monday Morning as base price and consider the average High Price and Average Low Price till Thursday Close*/
}

