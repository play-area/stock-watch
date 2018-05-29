<?php

require '../model/getNseBhavcopy.php';

if(count($_POST)>0) {
	$start_date= $_POST["startdate"];
	$end_date= $_POST["enddate"];
	if(!empty($start_date)) {
		getBhavCopy($start_date,$end_date);
	}
}
?>