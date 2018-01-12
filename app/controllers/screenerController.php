<?php

require '../model/performCalculations.php';

echo("Ajax Request got sent");
if(count($_POST)>0) {
	echo("</br>Inside Screener Controller isPost");
	echo("</br>Calculation Date = ".$_POST["calculationdate"]);
	updateCalculations($_POST["calculationdate"]);
}
?>