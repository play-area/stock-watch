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

    /* bind parameters for markers */
    $stmt->bind_param("s", $noOfDays);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($symbol,$recorddate,$open,$high,$low,$close,$prevclose,$volume);
	$i=0;
	while ($stmt->fetch()) {
		$queryResults[] = array('symbol' => $symbol,
			'timestamp' => $timestamp,
			'open' => $open,
			'high' => $high,
			'low' => $low,
			'close' => $close,
			'prevclose' => $prevclose,
			'volume' => $volume);
		if(($i+1)%$noOfDays == 0){
			$symbolSpecificResults[] = array('symbol' => $symbol,
				'values' => $queryResults);
			$queryResults = [];	
		}
		$i++;	
	}
	$stmt->close();
	$conn->close();
}
