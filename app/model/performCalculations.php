<?php

require "../config/dbcon.php";

/** Defining Querries */
define('DATE_LIST_QUERY', 'SELECT timestamp FROM daily_candlesticks_fo order by timestamp desc limit 50;');

define('SYMBOL_QUERY', 'SELECT * FROM daily_candlesticks_fo where timestamp in ;');

//Getting Bhav Copy files from NSE
function updateCalculations($calcDate){
	echo("</br>Inside performCalculations.php");
}

/* To calculate average of all types */
function calculateAverage($values,$period,$averageType='simple'){
	if($averageType='exp'){
		//Implement Formula to calculate EMA
	}else{
		$average=array_sum($values)/count($values);
		return $average;
	}
}