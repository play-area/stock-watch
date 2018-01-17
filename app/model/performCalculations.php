<?php

require "../config/dbcon.php";

/** Defining Querries */
define('DATE_LIST_QUERY', 'SELECT dc1.symbol, dc1.timestamp, dc1.open,dc1.high,dc1.low,dc1.close,dc1.prevclose,dc1.tottrdqty FROM daily_candlesticks_fo AS dc1
							INNER JOIN(SELECT DISTINCT timestamp FROM daily_candlesticks_fo ORDER BY timestamp desc limit ?) as dc2
							ON dc1.timestamp=dc2.timestamp
							GROUP BY dc1.symbol,dc1.timestamp');

/* Getting Results from database and performing calculations */
function updateCalculations($calcDate,$noOfDays=50){
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
    $stmt->bind_result($symbol,$timestamp,$open,$high,$low,$close,$prevclose,$volume);
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
	
	foreach($symbolSpecificResults as $symbolSpecificResult) {
		$calculationResults[] =calculateEverything($symbolSpecificResult['values'],$noOfDays);
	}
	if(!empty($calculationResults)){
		storeCalculationsInDatabase($calculationResults);
	}
}

/* To calculate everything */
function calculateEverything($symbolSpecificData,$noOfDays){
	$closingPrices50 = array();
	$volumes = array();
	$candleHeight = array();
	$candleBody = array();
	$change=array();
	$percentageChange=array();
	$closingPrices20 = array();
	$count=0;
	foreach($symbolSpecificData as $data){
		$closingPrices50[] = $data['close'];
		$volumes[] = $data['volume'];
		$candleBodies[] = abs($data['close']-$data['open']);
		$candleHeights[] =abs($data['high']-$data['low']);
		$change = ($data['close']-$data['prevclose']);
		if($count>=30){
			$closingPrices20[]= $data['close'];
		}
		$count++;
		$symbol=$data['symbol'];
		$timestamp=$data['timestamp'];
		$open=$data['open'];
		$high=$data['high'];
		$low=$data['low'];
		$close=$data['close'];
		$prevclose=$data['prevclose'];
		$volume=$data['volume'];
		$candleBody=abs($data['close']-$data['open']);
		$candleHeight=abs($data['high']-$data['low']);
	}
	$change=round($symbolSpecificData[$noOfDays-1]['close']-$symbolSpecificData[$noOfDays-1]['prevclose'],2);
	$changePercent=calculateChangePercent($symbolSpecificData[$noOfDays-1]['close'],$symbolSpecificData[$noOfDays-1]['prevclose']);
	$ma20= calculateAverage($closingPrices20);
	$ma50= calculateAverage($closingPrices50);
	$avgVol= calculateAverage($volumes);
	$avgCandleBody=calculateAverage($candleBodies);
	$avgCandleHeight=calculateAverage($candleHeights);
	//echo("SYMBOL=$symbol, timestamp=$timestamp, Close=$close,candleBody=$candleBody,candleHeight=$candleHeight, avgVol=$avgVol , avgCandleHeight=$avgCandleHeight , avgCandleBody=$avgCandleBody ,MA50=$ma50, MA20=$ma20,Change=$change, ChangePercent= $changePercent");
	return array('symbol' => $symbol,
			'timestamp' => $timestamp,
			'open' => $open,
			'high' => $high,
			'low' => $low,
			'close' => $close,
			'prevclose' => $prevclose,
			'volume' => $volume,
			'candleBody' => $candleBody,
			'candleHeight' => $candleHeight,
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

/* To calculate average of all types */
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
	$insert = $conn->prepare("INSERT INTO daily_candlesticks_fo_calculations (symbol, recorddate, open, high, low, close,prevclose, volume, candle_body, candle_height, change_value, change_percent,volavg50,ma20,ma50,avg_candle_body_50,avg_candle_height_50) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		foreach ($arrayToStore as $record) {
				$insert->bind_param("sssssssssssssssss",
					$record['symbol'],
					$record['timestamp'],
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
						'timestamp'=>$record['timestamp'],
						'error'=> $insert->error);
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