<?php

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
    if(empty($queryResults)){
        echo("No data present.");
        return;
    }
    echo("<span class='font-weight-600'>Table Name</span> : data_quandl_daily_liquid_options<br/>");
    echo("<span class='font-weight-600'>Table Description</span> : Quandl daily data for liquid options<br/>");
    echo("<span class='font-weight-600'>Total Records</span> : ".count($queryResults)."<br/>");
    echo("<span class='font-weight-600'>Start Date</span> : ".$queryResults[$i-1]['recorddate']."<br/>");
    echo("<span class='font-weight-600'>End Date</span> : ".$queryResults[0]['recorddate']."<br/>");
}
//Function to update the database by making calls to various functions.
function updateDatabase($dataSource,$watchListName,$timeFrame,$updateType,$startDate,$endDate,$tz = "Asia/Kolkata"){
    
    $startTime  = time();
    $dataTable       = "data_".$dataSource."_".$timeFrame."_".$watchListName;
    $watchListTable  = "watchlist_".$watchListName;
    $watchList       = getWatchListSymbols($watchListTable);
    
    //If update is full update then get the data for last 3 years or till wherever it is present.
    if($updateType==="full"){
        $todayDate = new DateTime("now", new DateTimeZone($tz));
        $endDate=$todayDate->format('Y-m-d');
        $startDate=$todayDate->modify('-3 year')->format('Y-m-d');
    }
    if($dataSource==="quandl"){
        //Deleting all records before insertion
        deleteTableData("data_quandl_daily_liquid_options",$updateType,$startDate,$endDate);
        updateDataFromQuandl($watchList,$startDate,$endDate);
    }
    echo("<span class='font-weight-600'>Total time(mins) = </span>".((time()-$startTime)/60));
}

//Function to get data from Quandl
function updateDataFromQuandl($symbolList,$startDate,$endDate){
    $apiKey = "UXsVDnMsYhtX_qVmVVLR";
    //$symbol = "NIFTY_BANK";
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
    /*This is needed because Indexes do not have a column called as "LAST" in Quandl data, whereas other Symbols have "LAST" column */
    $closePriceColNo = ($symbol == "NIFTY_BANK" || $symbol == "NIFTY_50")?4:5;
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
            $record[$closePriceColNo],
            $record[6]
            );
        $insert->execute();
    }
}

function deleteTableData($tableName,$updateType,$startDate,$endDate){
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    //To check for connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if($updateType == "full"){
        $conn->query("Delete from $tableName");
        
    }else if($updateType=="partial"){
        
        $query = "DELETE FROM $tableName WHERE recorddate BETWEEN ?  AND ?";
        
        /* create a prepared statement */
        $stmt = $conn->prepare($query);
        
        /* Binding Parameters */
        $stmt->bind_param("ss",$startDate,$endDate);
        
        /* execute query */
        $stmt->execute();
    }
}

//Function to get list of symbols from a watchlist
function getWatchListSymbols($watchListTable){
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    /* getting results*/
    $result =$conn->query("Select symbol FROM $watchListTable");
    
    $symbolList = array();
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $symbolList[]    =   $row["symbol"];
        }
    } else {
        echo "0 results";
    }
    
    return $symbolList;
}

?>