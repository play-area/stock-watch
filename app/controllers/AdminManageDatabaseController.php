<?php

require '../model/AdminManageDatabase.php';
if(count($_POST)>0) {
	//Checking if Update database form has been submitted based on value of hidden input field act
	if($_POST["act"]==="update-database"){
		if($_POST["update-type"]==="partial" && empty($_POST["startdate"]) && empty($_POST["enddate"]) ){
			echo("Please fill all the fields in the form");
			return;
		}
		updateDatabase($_POST["data-source"],$_POST["watchlist"],$_POST["time-frame"],$_POST["update-type"],$_POST["startdate"],$_POST["enddate"]);
	}
}
?>