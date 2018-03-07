<?php

require "../config/dbcon.php";

//Function to update the database by making calls to various functions.
function updateDatabase($dataSource,$watchListName,$timeFrame,$updateType,$startDate,$endDate,$tz = "Asia/Kolkata"){
	//echo("dataSource=$dataSource,watchList=$watchList,timeFrame=$timeFrame,updateType=$updateType,stDate=$startDate,edDate=$endDate,tz=$tz");
	$watchList = getWatchListSymbols($watchListName);
	
	//If update is full update then get the data for last 3 years or till wherever it is present.
	if($updateType==="full"){
		$todayDate = new DateTime("now", new DateTimeZone($tz));
		$endDate=$todayDate->format('Y-m-d');
		$startDate=$todayDate->modify('-3 year')->format('Y-m-d');
	}
	if($dataSource==="quandl"){
		updateDataFromQuandl($watchList,$startDate,$endDate);
	}
}

//Function to get data from Quandl
function updateDataFromQuandl($symbolList,$startDate,$endDate){
	$apiKey = "UXsVDnMsYhtX_qVmVVLR";
	$symbol = "VEDL";
	deleteTableData("data_quandl_daily_liquid_options");
	foreach($symbolList as $symbol){
		$url = "https://www.quandl.com/api/v3/datasets/NSE/$symbol.json?api_key=$apiKey&start_date=$startDate&end_date=$endDate";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); // To Prevent output to be displayed on screen
		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // To get HTTP Code
		curl_close($ch);
		if($httpcode !='200'){
			echo("Could not get data for Symbol = $symbol");
		}
		$responseJson=json_decode($response, true);
		echo("Request URL = $url");
		setDataFromQuandl($symbol,$responseJson["dataset"]["data"]);
	}
}

function setDataFromQuandl($symbol,$queryResults){
	
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	//To check for connection error
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$insert = $conn->prepare("INSERT INTO data_quandl_daily_liquid_options (recorddate,symbol,open, high, low, close,volume) VALUES (?,?,?,?,?,?,?)");
	foreach ($queryResults as $record){
		$insert->bind_param("sssssss",
			$record[0],
			$symbol,
			$record[1],
			$record[2],
			$record[3],
			$record[5],
			$record[6]
		);
		$insert->execute();	 
	}
}

function deleteTableData($tableName){
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	//To check for connection error
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	if($conn->query("Delete from $tableName")){
		echo ("All Records deleted successfully");
	}else{
		echo ("Error deleting record: " . $conn->error);
	}	
}

//Function to get list of symbols from a watchlist
function getWatchListSymbols($watchList){
	if($watchList==="liquid-options"){
		//return ["SBIN"];
		return ["NIFTY_BANK","NIFTY_50","SBIN","RELIANCE","ASHOKLEY"];	
	}
}