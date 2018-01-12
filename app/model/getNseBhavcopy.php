<?php

require "../config/dbcon.php";

//Getting Bhav Copy files from NSE
function getBhavCopy($stDate,$edDate,$tz = "Asia/Kolkata"){
	$startDate = new DateTime($stDate, new DateTimeZone($tz));
	$endDate = new DateTime($edDate, new DateTimeZone($tz));
	//echo("</br>Start Date in Date Format=" .$startDate->format('d-m-Y'));
	$listOfHolidays = getHolidays("NSE");
	if(!empty($startDate) && !empty($endDate))
	{
		$period = new DatePeriod(
			$startDate,
			new DateInterval('P1D'),
			$endDate->modify( '+1 day')
		);
		foreach ($period as $key => $value) {
			$day = $value->format("D");
			$isSaturday = strcmp($day,"Sat");
			$isSunday   = strcmp($day,"Sun");
			if(!in_array($value->format("Y-m-d"),$listOfHolidays) && $isSaturday!=0 && $isSunday!=0){
					echo("<h3>Getting Bhav Copy for".$value->format('Y-m-d')."</h3>");
					getBhavCopyFromNse($value);
				}
		}
	}else if(!empty($startDate) && empty($endDate)){
		
	}else if(empty($startDate) && empty($endDate)){
		
	}
}

//Making curl request to NSE.
function getBhavCopyFromNse($date){
	//Forming file name
	$bhavcopy_file = sprintf('cm%s%s%dbhav.csv.zip', 
	$date->format('d'), 
	strtoupper($date->format('M')), 
	$date->format('Y')
	);
	
	//Forming url
	$bhavcopy_url = sprintf('https://www.nseindia.com/content/historical/EQUITIES/%d/%s/%s', 
	$date->format('Y'), 
	strtoupper($date->format('M')), 
	$bhavcopy_file
	);
	
	printf(_pstr("Inside getBhavCopy method Downloading bhavcopy file from %s..."), $bhavcopy_url);
	
	//Making curl request to NSE .
	$ch = curl_init($bhavcopy_url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); 
	$output = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if($httpcode != 200){
		printf(_pstr("Bhavcopy not found at %s. HTTP error: %s", 'error'), $bhavcopy_url, $httpcode);
		exit();	
	}else if($httpcode == 200){
		printf(_pstr("Bhavcopy found at %s"), $bhavcopy_url);
		storeBhavCopy($bhavcopy_file,$output,$date );
	}
}

// Reading and storing Bhav Copy file in db
function storeBhavCopy($bhavcopy_file,$output,$date){
	
	$fh = fopen($bhavcopy_file, 'w');
	fwrite($fh, $output);
	fclose($fh);

	printf(_pstr("Saving bhavcopy file %s"), $bhavcopy_file);

	$zip = new ZipArchive;
	$res = $zip->open($bhavcopy_file);

	if ($res === TRUE) {

		printf(_pstr("Extracting bhavcopy file %s"), $bhavcopy_file);
		$zip->extractTo(getcwd());
		$zip->close();
		$bhavcopy_csvfile = str_replace('.zip','',$bhavcopy_file);

		printf(_pstr("Parsing bhavcopy csv file %s"), $bhavcopy_csvfile);
		$bhavcopy_rows = array_map('str_getcsv', file($bhavcopy_csvfile));
		$header = array_shift($bhavcopy_rows);
		$bhavcopy_array = array();
		foreach ($bhavcopy_rows as $bhavcopy_row) {
			$bhavcopy_array[] = array_combine($header, $bhavcopy_row);
		}

		printf(_pstr("Checking database..."));
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (mysqli_connect_errno()) {
			printf(_pstr("Database connect failed. Error: %s", 'error'), mysqli_connect_error());
			delete_files($bhavcopy_file, $bhavcopy_csvfile);
			exit();
		}
		$mysqli->set_charset("utf8");
		$mysql_date = $date->format('Y-m-d');
		$count = $mysqli->query('SELECT count(*) as count FROM daily_candlesticks_fo WHERE timestamp = "'.$mysqli->real_escape_string($mysql_date).'"');
		$count_row = $count->fetch_array(MYSQLI_ASSOC);
		$count->free();
		if($count_row['count'] > 0){
			printf(_pstr("Data already exists for date %s", 'error'), $mysql_date);
			delete_files($bhavcopy_file, $bhavcopy_csvfile);
			return;
		}

		printf(_pstr("Attempting to insert %s records..."), count($bhavcopy_array));
		$insert = $mysqli->prepare("INSERT INTO daily_candlesticks_fo (symbol, series, open, high, low, close, last, prevclose, tottrdqty, tottrdval, timestamp, totaltrades, isin) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
		foreach ($bhavcopy_array as $record) {
			if(($record['SYMBOL']=='SBIN' || $record['SYMBOL']=='HINDALCO')&& $record['SERIES']=='EQ'){
				$insert->bind_param("sssssssssssss",
					$record['SYMBOL'],
					$record['SERIES'],
					$record['OPEN'],
					$record['HIGH'],
					$record['LOW'],
					$record['CLOSE'],
					$record['LAST'],
					$record['PREVCLOSE'],
					$record['TOTTRDQTY'],
					$record['TOTTRDVAL'],
					$mysql_date,
					$record['TOTALTRADES'],
					$record['ISIN']		
				);
				$insert->execute();	 
				if($insert->error) {
					printf(_pstr("Error inserting %s: %s.", 'error'), $record['SYMBOL'], $insert->error);
				}
			}
		}
		$insert->close();
		$mysqli->close();

		delete_files($bhavcopy_file, $bhavcopy_csvfile);

	} else {
		printf(_pstr("Extracting failed. Error code: %s", 'error'), $res);
		exit();
	}
}

// Get Today's date for a particular timezone, default timezone is Europe/London
function date_tz($format, $timestamp = false, $tz = 'Europe/London'){
	if(!$timestamp) $timestamp = time();
	$dt = new DateTime("now", new DateTimeZone('Asia/Kolkata')); 
	$dt->setTimestamp($timestamp);
	if($format == 'DateTime') return $dt;
	return $dt->format($format);	
}

function delete_files($bhavcopy_file, $bhavcopy_csvfile){
	printf(_pstr("Deleting downloaded files... %s and %s"), $bhavcopy_file, $bhavcopy_csvfile);
	unlink($bhavcopy_file);
	unlink($bhavcopy_csvfile);
}

function _pstr($t, $m = '') {
	if(PHP_SAPI !== 'cli'){
		$color = ($m == 'error' ? 'color: red' : '');
		return '<p style="font-family: monospace;'.$color.'">'.$t.'</p>'.PHP_EOL;
	} else {
		$color = ($m == 'error' ? chr(27).'[0;31m' : '');
		return $color.$t.' '.chr(27).'[0m'.PHP_EOL;
	}
}

function getHolidays($market){
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	/* create a prepared statement */
	$stmt = $conn->prepare("select * from trading_holidays where market=?");

    /* bind parameters for markers */
    $stmt->bind_param("s", $market);

    /* execute query */
    $stmt->execute();

    /* bind result variables */
    $stmt->bind_result($market,$date);

	// Loop the results and fetch into an array
	$dates = array();
	while ($stmt->fetch()) {
		$dates[] = $date;
	}
	//print_r($dates);
	$stmt->close();
	$conn->close();
	
	return $dates;
}