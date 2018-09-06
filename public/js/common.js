$(function() {
	$('.btn-add,.btn-remove').click(function(event) {
		event.stopImmediatePropagation();
		$('.alerts-row .alert-success').hide();
		$('.alerts-row .alert-danger').hide();
		if($(this).hasClass('btn-add')){
			$('.alerts-row .alert-success').fadeIn(1500);
			$('.alerts-row .alert-success').fadeOut(2000);
		}else if($(this).hasClass('btn-remove')){
			$(this).parents('tr').remove();
			$('.alerts-row .alert-danger').fadeIn(1500);
			$('.alerts-row .alert-danger').fadeOut(2000);
			
		}
	});
	
	$('.close-alert').click(function(e) 
	{   
		$(this).parent().hide();
	});
	
	//To show or hide Days dropdown if user selects weekly option
	$('#time-period').change(function(){
		var optionValue = $(this).find('option:selected').attr('value');
		if(optionValue === "Weekly"){
			$('#start-day').parents('div.form-group').show();
			$('#end-day').parents('div.form-group').show();
		}else if(optionValue ==="Monthly"){
			$('#start-day').parents('div.form-group').hide();
			$('#end-day').parents('div.form-group').hide();
		}
	});
	
	//Ajax request to show database stats on load of Admin Update Database page
	getUpdateDatabaseStats();
	
	//Ajax request to show Options Symbol list on load of Options page
	getOptionsSymbolList();
	
	
});



/* -----------------------------JS for Options Page --------------------- START----------- -------------*/

//Function for Ajax Request to show symbol list
function getOptionsSymbolList(){
	$.ajax({
		url: "../app/controllers/OptionsController.php",
		type: "get",
		success: function (response) {
			$('#calculations-symbol-list').html(response);
			$('#strikes-symbol-list').html(response);
		},
		error: function(jqXHR, textStatus, errorThrown) {
		   console.log(textStatus, errorThrown);
		}
	});
}

function calculateStockStats(){
	//Preventing form submit as it will lead to page refresh
	event.preventDefault();
	//Get Form data
	var formData = $('.options-form').serialize();
	//console.log("Form Data="+formData);
	//Send Ajax Request
	var resultsDiv = $('.results div');
	$.ajax({
		url: "../app/controllers/OptionsController.php",
		type: "post",
		data: formData,
		success: function (response) {
			resultsDiv.html(response);
		},
		error: function(jqXHR, textStatus, errorThrown) {
		   console.log(textStatus, errorThrown);
		}
	});
}

function calculateStrikes(){
	//Preventing form submit as it will lead to page refresh
	event.preventDefault();
	//Get Form data
	var formData = $('.strikes-form').serialize();
	//console.log("Form Data="+formData);
	//Send Ajax Request
	var resultsDiv = $('.strike-results div');
	$.ajax({
		url: "../app/controllers/OptionsController.php",
		type: "post",
		data: formData,
		success: function (response) {
			resultsDiv.html(response);
		},
		error: function(jqXHR, textStatus, errorThrown) {
		   console.log(textStatus, errorThrown);
		}
	});
}

function showHideManualEntry(currentElement){
	var currentSelection = $(currentElement).val();
	var elementToShowHide	= '#'+$(currentElement).attr('name')+'-manual';
	if(currentSelection==='manual'){
		$(elementToShowHide).show();
	}else{
		$(elementToShowHide).hide();
	}
}

/* -----------------------------JS for Options Page --------------------- END----------- -------------*/

/* -----------------------------JS for Admin Pages------------------------START-----------------------*/

//Function for Ajax Request on Update Database Page
function getUpdateDatabaseStats(){
	$.ajax({
		url: "../app/controllers/AdminManageDatabaseController.php",
		type: "get",
		success: function (response) {
			$('#onload-results').html(response);
		},
		error: function(jqXHR, textStatus, errorThrown) {
		   console.log(textStatus, errorThrown);
		}
	});
}


function showHideUpdateDatabaseDates(currentElement){
	var currentSelection = $(currentElement).val();
	var currentSelectionName = $(currentElement).attr('name');
	if(currentSelectionName==='update-type'){
		var startDate=$('#startdate').parents('div.form-group');
		var endDate=$('#enddate').parents('div.form-group');
		if(currentSelection==='partial'){
			startDate.show();
			endDate.show();
			
		}else if(currentSelection==='full'){
			startDate.hide();
			endDate.hide();
		}
	}else if(currentSelectionName==='update-type-calculations'){
		var startDate=$('#startdate-calculations').parents('div.form-group');
		var endDate=$('#enddate-calculations').parents('div.form-group');
		if(currentSelection==='partial'){
			startDate.show();
			endDate.show();
			
		}else if(currentSelection==='full'){
			startDate.hide();
			endDate.hide();
		}
	}
	
}

function updateDatabase(){
	//Preventing form submit as it will lead to page refresh
	event.preventDefault();
	//Get Form data
	var formData = $('.update-database-form').serialize();
	//Send Ajax Request
	var resultsDiv 		= 	$('#results-div');
	var logsMessageDiv  =	$('#logs-message');
	var onLoadResultsDiv =	$('#onload-results');
	resultsDiv.hide();
	logsMessageDiv.hide();
	onLoadResultsDiv.show();
	onLoadResultsDiv.html('Updating Database , please wait...<br/><br/><img src="images/spinners/spinner1.gif">');
	$.ajax({
		url: "../app/controllers/AdminManageDatabaseController.php",
		type: "post",
		data: formData,
		success: function (response) {
			resultsDiv.html(response);
			resultsDiv.show();
			logsMessageDiv.show();
			onLoadResultsDiv.hide();
		},
		error: function(jqXHR, textStatus, errorThrown) {
		   console.log(textStatus, errorThrown);
		}
	});
	
}

function updateCalculations(){
	//Preventing form submit as it will lead to page refresh
	event.preventDefault();
	var formCheckBoxes=$('.calculations-form  .calculation-checkbox');
	var alertSuccess = $('.alerts-row .alert-success');
	var alertDanger = $('.alerts-row .alert-danger');
	var alertInfo = $('.alerts-row .alert-info');
	var onLoadResultsDiv =	$('#onload-calc-results');
	formCheckBoxes.each(function() {
	  if ($(this).is(":checked")) {
            console.log($(this).attr('id')+" is Checked");
        }
	});
	var formData = $('.calculations-form').serialize();
	
	alertSuccess.hide();
	alertDanger.hide();
	alertInfo.hide();
	
	onLoadResultsDiv.show();
	onLoadResultsDiv.html('Updating Calculations , please wait...<br/><br/><img src="images/spinners/spinner1.gif">');
	
	//Send Ajax Request
	$.ajax({
		url: "../app/controllers/AdminManageDatabaseController.php",
		type: "post",
		data: formData,
		success: function (response) {
			//console.log(response); 
			event.stopImmediatePropagation();
			onLoadResultsDiv.hide();
			alertInfo.find('div').html(response);
			alertInfo.fadeIn(2000);
		},
		error: function(jqXHR, textStatus, errorThrown) {
		   console.log(textStatus, errorThrown);
		}
	});
}

/* -----------------------------JS for Admin Pages------------------------END-----------------------*/
