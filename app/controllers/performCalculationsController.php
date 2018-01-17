<?php

require '../model/performCalculations.php';

if(count($_POST)>0) {
	updateCalculations($_POST["calculationdate"]);
}
?>