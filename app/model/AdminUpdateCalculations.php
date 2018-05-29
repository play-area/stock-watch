<?php

/** Defining Querries */
define('DATE_LIST_QUERY', 'SELECT dc1.symbol, dc1.recorddate, dc1.open,dc1.high,dc1.low,dc1.close,dc1.volume FROM data_quandl_daily_liquid_options AS dc1 INNER JOIN(SELECT DISTINCT recorddate FROM data_quandl_daily_liquid_options ORDER BY recorddate desc limit ?) as dc2 ON dc1.recorddate=dc2.recorddate GROUP BY dc1.symbol,dc1.recorddate');

define('WORKING_DAYS','SELECT T1.date_selected FROM (SELECT (CURRENT_DATE - INTERVAL 100 DAY) + INTERVAL a + b DAY AS date_selected
FROM (SELECT 0 a UNION SELECT 1 a UNION SELECT 2 UNION SELECT 3
UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
UNION SELECT 8 UNION SELECT 9 ) d,
(SELECT 0 b UNION SELECT 10 UNION SELECT 20
UNION SELECT 30 UNION SELECT 40 UNION SELECT 50 UNION SELECT 60 UNION SELECT 70 UNION SELECT 80 UNION SELECT 90) m
WHERE (CURRENT_DATE - INTERVAL 100 DAY) + INTERVAL a + b DAY < CURRENT_DATE
ORDER BY a + b)T1 WHERE T1.date_selected NOT IN (SELECT HOLIDAYDATE FROM TRADING_HOLIDAYS) AND DAYOFWEEK(T1.date_selected) NOT IN (1,7)
ORDER BY `T1`.`date_selected`  DESC limit 50');

/*If I run the query on 26th January ->
 Then it should check if 26th is a holiday or not,
 Check if the data till today is updated for the last 50 days in the daily_candlesticks_fo table.
 If it is a holiday,
 then perform calculations for the last 50 day starting from the last working day.
 */

/*Function to check if the records are updated in the daily candlesticks table*/
function checkDataInTable($noOfDays){
    $listOfWorkingDays = getWorkingDays($noOfDays);
    $listOfRecordedDates = getRecordDates($noOfDays);
    $result = array_diff($array1, $array2);
    if(empty($result)){
        $result = array_diff($array1, $array2);
    }
    return $result;
}

/* Getting Results from database and performing calculations */
function updateCalculations($noOfDays=550){
    /*$errorDates=checkDataInTable($noOfDays);
     if(!empty($errorDates)){
     echo("</br><h3>Please check the following dates in the <b>Daily Candlesticks</b> table:</h3></br>");
     for($errorDates as $errorDate){
     echo("<br>"+$errorDate);
     }
     return;
     }*/
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    /* create a prepared statement */
    $stmt = $conn->prepare(DATE_LIST_QUERY);
    
    /* bind parameters for markers */
    $stmt->bind_param("s", $noOfDays);
    
    /* execute query */
    $stmt->execute();
    
    /* bind result variables */
    $stmt->bind_result($symbol,$recorddate,$open,$high,$low,$close,$volume);
    $i=0;
    while ($stmt->fetch()) {
        $queryResults[] = array('symbol' => $symbol,
            'recorddate' => $recorddate,
            'open' => $open,
            'high' => $high,
            'low' => $low,
            'close' => $close,
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
    
    foreach($symbolSpecificResults as $symbolSpecificResult) {
        $calculationResults[] =calculateEverything($symbolSpecificResult['values'],$noOfDays);
    }
    if(!empty($calculationResults)){
        storeCalculationsInDatabase($calculationResults);
    }
}


/* To calculate everything */
function calculateEverything($symbolSpecificData,$noOfDays){
    $calculationResults =  array();
    $closingPrices = array();
    $volumes = array();
    $candleHeight = array();
    $candleBody = array();
    $change=array();
    $percentageChange=array();
    $closingPrices20 = array();
    $count=0;
    for($i=1;$i<sizeof($symbolSpecificData);$i++){
        $prevclose=$symbolSpecificData[$i-1]['close'];
        $closingPrices[] = $symbolSpecificData[$i]['close'];
        $volumes[] = $symbolSpecificData[$i]['volume'];
        $candleBodies[] = abs($symbolSpecificData[$i]['close']-$symbolSpecificData[$i]['open']);
        $candleHeights[] =abs($symbolSpecificData[$i]['high']-$symbolSpecificData[$i]['low']);
        $candleType = 'Doji';
        $change = round($symbolSpecificData[$i]['close']-$prevclose,2);
        $changePercent=calculateChangePercent($symbolSpecificData[$i]['close'],$prevclose);
        if($i>=50){
            $ma20= calculateAverage(array_slice($closingPrices, -20));
            $ma50= calculateAverage(array_slice($closingPrices, -50));
            $avgVol= calculateAverage(array_slice($volumes, -50));
            $avgCandleBody=calculateAverage(array_slice($candleBodies, -50));
            $avgCandleHeight=calculateAverage(array_slice($candleHeights, -50));
            $calculationResults[] = createCalculationsArray($symbolSpecificData[$i]['symbol'],$symbolSpecificData[$i]['recorddate'],$symbolSpecificData[$i]['open'],$symbolSpecificData[$i]['high'],$symbolSpecificData[$i]['low'],$symbolSpecificData[$i]['close'],$prevclose,$symbolSpecificData[$i]['volume'],$candleBodies[$i-1],$candleHeights[$i-1],$candleType,$change,$changePercent,$avgVol,$ma20,$ma50,$avgCandleBody,$avgCandleHeight);
        }
    }
    return $calculationResults;
}

/* Function to Create array of calculated values*/
function createCalculationsArray($symbol,$recorddate,$open,$high,$low,$close,$prevclose,$volume,$candleBody,$candleHeight,$candleType,$change,$changePercent,$avgVol,$ma20,$ma50,$avgCandleBody,$avgCandleHeight){
    return array('symbol' => $symbol,
        'recorddate' => $recorddate,
        'open' => $open,
        'high' => $high,
        'low' => $low,
        'close' => $close,
        'prevclose' => $prevclose,
        'volume' => $volume,
        'candleBody' => $candleBody,
        'candleHeight' => $candleHeight,
        'candleType' => $candleType,
        'change'=>$change,
        'changePercent'=>$changePercent,
        'avgVol'=>$avgVol,
        'ma20'=>$ma20,
        'ma50'=>$ma50,
        'avgCandleBody'=>$avgCandleBody,
        'avgCandleHeight'=>$avgCandleHeight
    );
}

/* To calculate average of all types */
function calculateAverage($values,$averageType='simple'){
    $average=array_sum($values)/count($values);
    return $average;
}

/* To calculate percentage change */
function calculateChangePercent($close,$prevClose){
    $percentageChange=round(($close-$prevClose)*100/$close,2);
    return $percentageChange;
}

/* To store data in database */
function storeCalculationsInDatabase($arrayToStore){
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $errorList=array();
    $insert = $conn->prepare("INSERT INTO calculations_daily_liquid_options (symbol, recorddate, open, high, low, close,prevclose, volume, candle_body, candle_height, change_value, change_percent,volavg50,ma20,ma50,avg_candle_body_50,avg_candle_height_50) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    foreach ($arrayToStore as $arrayRecord) {
        foreach($arrayRecord as $record){
            $insert->bind_param("sssssssssssssssss",
                $record['symbol'],
                $record['recorddate'],
                $record['open'],
                $record['high'],
                $record['low'],
                $record['close'],
                $record['prevclose'],
                $record['volume'],
                $record['candleBody'],
                $record['candleHeight'],
                $record['change'],
                $record['changePercent'],
                $record['avgVol'],
                $record['ma20'],
                $record['ma50'],
                $record['avgCandleBody'],
                $record['avgCandleHeight']
                );
            $insert->execute();
            if($insert->error) {
                //echo("<h3>Error Inserting Records to database</h3>".$insert->error);
                $errorList[]=array('symbol'=>$record['symbol'],
                    'recorddate'=>$record['recorddate'],
                    'error'=> $insert->error);
            }
        }
    }
    $insert->close();
    $conn->close();
    if(empty($errorList)){
        echo("Calculations perfomed successfully for all symbols");
    }else{
        echo("</br><h3>Error List below:</h3></br>");
        echo("<table class='table table-striped'><tr><th>Symbol</th><th>Timestamp</th><th>Error</th></tr>");
        foreach($errorList as $error){
            //echo($error['symbol']);
            echo("<tr><td>".$error['symbol']."</td><td>".$error['timestamp']."</td><td>".$error['error']."</td></tr>");
        }
        echo("</table>");
    }
}

/* Function to get last n working days for the market*/
function getWorkingDays($noOfWorkingDays){
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    /* create a prepared statement */
    $stmt = $conn->prepare("WORKING_DAYS");
    
    /* bind parameters for markers */
    $stmt->bind_param("s", $noOfWorkingDays);
    
    /* execute query */
    $stmt->execute();
    
    /* bind result variables */
    $stmt->bind_result($date);
    
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
/* Function to get last n records from the daily candlesticks table*/
function getRecordDates($noOfDays){
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    /* create a prepared statement */
    $stmt = $conn->prepare("SELECT DISTINCT timestamp FROM daily_candlesticks_fo ORDER BY timestamp desc limit ?");
    
    /* bind parameters for markers */
    $stmt->bind_param("s", $noOfDays);
    
    /* execute query */
    $stmt->execute();
    
    /* bind result variables */
    $stmt->bind_result($timestamp);
    // Loop the results and fetch into an array
    $dates = array();
    while ($stmt->fetch()) {
        $dates[] = $timestamp;
    }
    
    $stmt->close();
    $conn->close();
    
    return $dates;
}
?>