<?php

require '../model/optionsCalculations.php';
if(count($_POST)>0) {
	calculateOptions();
}
?>