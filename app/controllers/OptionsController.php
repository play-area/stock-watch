<?php

require '../model/optionsCalculations.php';
if(count($_POST)>0) {
	if($_POST["time-period"]==="Monthly"){
		calculateMonthlyOptionsData($_POST["symbol"],$_POST["lower-price"],$_POST["upper-price"]);
	}else if($_POST["time-period"]==="Weekly"){
		getWeeklyPriceRange($_POST["symbol"],$_POST["lower-price"],$_POST["upper-price"],$_POST["start-day"],$_POST["end-day"]);
	}
}
?>