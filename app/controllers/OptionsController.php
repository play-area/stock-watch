<?php

require '../model/optionsCalculations.php';
if(isset($_POST["options-form"])){
   echo "Options form been submitted";
}
if(count($_POST)>0) {
	//Checking if Calculate stats form has been submitted based on value of hidden input field act
	if($_POST["act"]==="calculate-strikes"){
		//Validating if all fields are filled or not.
		if(empty($_POST["spot-price"]) || empty($_POST["daily-return"]) ||empty($_POST["daily-volatility"]) || empty($_POST["days-to-expiry"])){
			echo("Please fill out all fields in the form");
			return;
			if($_POST["daily-return"]==="manual" && empty($_POST["daily-return-manual"])){
				echo("Please fill out all fields in the form");
				return;
			}
			if($_POST["daily-volatility"]==="manual" && empty($_POST["daily-volatility-manual"])){
				echo("Please fill out all fields in the form");
				return;
			}
		}else{
			getStrikes($_POST["symbol"],$_POST["spot-price"],$_POST["daily-return"],$_POST["daily-return-manual"],$_POST["daily-volatility"],$_POST["daily-volatility-manual"],$_POST["days-to-expiry"]);
		}
	}
	//Checking if Calculate stats form has been submitted based on value of hidden input field act
	if($_POST["act"]==="calculate-stats"){
		if($_POST["time-period"]==="Monthly"){
			getMonthlyPriceRange($_POST["symbol"],$_POST["lower-price"],$_POST["upper-price"]);
		}else if($_POST["time-period"]==="Weekly"){
			getWeeklyPriceRange($_POST["symbol"],$_POST["lower-price"],$_POST["upper-price"],$_POST["start-day"],$_POST["end-day"]);
		}
	}

}
?>