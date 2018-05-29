<?php

require '../model/AdminManageDatabase.php';

//Checking if Request is of POST type
if(count($_POST)>0) {
	//Checking if Update database form has been submitted based on value of hidden input field act
	if($_POST["act"]==="update-database"){
		if($_POST["update-type"]==="partial"){
		    if(!validateDates($_POST["startdate"],$_POST["enddate"])){
		        return;
		    }
		}
		updateDatabase($_POST["data-source"],$_POST["watchlist"],$_POST["time-frame"],$_POST["update-type"],$_POST["startdate"],$_POST["enddate"]);
	}
	else if($_POST["act"]==="update-calculations"){
	    updateCalculations();
	}
}
else{
    //If Request is other than POST
    getDataOnPageLoad();
}

?>