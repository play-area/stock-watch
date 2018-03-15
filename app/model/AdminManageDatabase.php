<?php

require "../config/dbcon.php";

//Function to validate dates
function validateDates($startDate,$endDate,$tz = "Asia/Kolkata"){
    date_default_timezone_set($tz);
    if(empty($startDate) || empty($endDate)){
        echo("Start Date and End Date need to be filled");
        return false;
    }
    $startDate  =   new DateTime($startDate,new DateTimeZone($tz));
    $endDate    =   new DateTime($endDate,new DateTimeZone($tz));
    $todaysDate =   new DateTime();
    if($startDate > $endDate){
        echo("Start Date should be less than end date");
        return false;
    }else if($startDate > $todaysDate || $endDate>$todaysDate ){
        echo("Start Date and End Date should not exceed today's date");
        return false;
     }
    return true;
}

//Function to show data on page load
function getDataOnPageLoad(){
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    /* create a prepared statement */
    $stmt = $conn->prepare("SELECT * FROM data_quandl_daily_liquid_options ORDER BY recorddate DESC");
    
    /* execute query */
    $stmt->execute();
    
    /* bind result variables */
    $stmt->bind_result($recorddate,$symbol,$open,$high,$low,$close,$volume);
    $i=0;
    while ($stmt->fetch()) {
        $queryResults[] = array('recorddate' => $recorddate,
            'symbol' => $symbol,
            'open' => $open,
            'high' => $high,
            'low' => $low,
            'close' => $close,
            'volume' => $volume
        );
        $i++;
    }
    echo("<span class='font-weight-600'>Table Name</span> : data_quandl_daily_liquid_options<br/>");
    echo("<span class='font-weight-600'>Table Description</span> : Quandl daily data for liquid options<br/>");
    echo("<span class='font-weight-600'>Total Records</span> : ".count($queryResults)."<br/>");
    echo("<span class='font-weight-600'>Start Date</span> : ".$queryResults[$i-1]['recorddate']."<br/>");
    echo("<span class='font-weight-600'>End Date</span> : ".$queryResults[0]['recorddate']."<br/>");
}
//Function to update the database by making calls to various functions.
function updateDatabase($dataSource,$watchListName,$timeFrame,$updateType,$startDate,$endDate,$tz = "Asia/Kolkata"){
	$startTime = time();
	$watchList = getWatchListSymbols($watchListName);
	
	//If update is full update then get the data for last 3 years or till wherever it is present.
	if($updateType==="full"){
		$todayDate = new DateTime("now", new DateTimeZone($tz));
		$endDate=$todayDate->format('Y-m-d');
		$startDate=$todayDate->modify('-3 year')->format('Y-m-d');
		//Deleting all records before insertion in case of full update
		deleteTableData("data_quandl_daily_liquid_options");
	}
	if($dataSource==="quandl"){
		updateDataFromQuandl($watchList,$startDate,$endDate);
	}
	echo("<span class='font-weight-600'>Total time(mins) = </span>".((time()-$startTime)/60));
}

//Function to get data from Quandl
function updateDataFromQuandl($symbolList,$startDate,$endDate){
	$apiKey = "UXsVDnMsYhtX_qVmVVLR";
	$symbol = "VEDL";
	$i=1;
	echo("<table class='table table-striped'><tr><th>Sl No.</th><th>Symbol</th><th>Records</th></tr>");
	foreach($symbolList as $symbol){
		$url = "https://www.quandl.com/api/v3/datasets/NSE/$symbol.json?api_key=$apiKey&start_date=$startDate&end_date=$endDate";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); // To Prevent output to be displayed on screen
		$response = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // To get HTTP Code
		curl_close($ch);
		if($httpcode !='200'){
			//echo("Could not get data for Symbol = $symbol");
		}
		$responseJson=json_decode($response, true);
		echo("<tr><td>".$i++."</td><td>$symbol</td><td>".count($responseJson["dataset"]["data"])."</td></tr>");
		setDataFromQuandl($symbol,$responseJson["dataset"]["data"]);
	}
	echo("</table>");
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
		//echo ("All Records deleted successfully");
	}else{
		echo ("Error deleting record: " . $conn->error);
	}	
}

//Function to get list of symbols from a watchlist
function getWatchListSymbols($watchList){
	if($watchList==="liquid-options"){
		//return ["SBIN"];
		return ["NIFTY_BANK","NIFTY_50","SBIN","PNB","ICICIBANK","HDFCBANK","YESBANK","RELIANCE","LT","IDEA","BHARTIARTL","HINDALCO","VEDL","TATASTEEL","TCS","INFY","ASHOKLEY","TATAMOTORS","MARUTI","SUNPHARMA","LUPIN","ITC"];	
	}
}