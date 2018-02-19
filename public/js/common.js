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
	
	$(".close-alert").click(function(e) 
	{   
		$(this).parent().hide();
	});
});

function updateCalculations(){
	//Preventing form submit as it will lead to page refresh
	event.preventDefault();
	var formCheckBoxes=$('.calculations-form  .calculation-checkbox');
	var alertSuccess = $('.alerts-row .alert-success');
	var alertDanger = $('.alerts-row .alert-danger');
	var alertInfo = $('.alerts-row .alert-info');
	formCheckBoxes.each(function() {
	  if ($(this).is(":checked")) {
            console.log($(this).attr('id')+" is Checked");
        }
	});
	var date= $('.calculations-form  #calculationdate');
	console.log(date.val());
	
	alertSuccess.hide();
	alertDanger.hide();
	alertInfo.hide();
	
	//Send Ajax Request
	$.ajax({
		url: "../app/controllers/performCalculationsController.php",
		type: "post",
		data: date,
		success: function (response) {
			//console.log(response); 
			event.stopImmediatePropagation();
			alertInfo.find('div').html(response);
			alertInfo.fadeIn(2000);
		},
		error: function(jqXHR, textStatus, errorThrown) {
		   console.log(textStatus, errorThrown);
		}
	});
}

function calculateOptions(){
	//Preventing form submit as it will lead to page refresh
	event.preventDefault();
	//Send Ajax Request
	$.ajax({
		url: "../app/controllers/OptionsController.php",
		type: "post",
		data: "abc",
		success: function (response) {
			console.log(response); 
		},
		error: function(jqXHR, textStatus, errorThrown) {
		   console.log(textStatus, errorThrown);
		}
	});
}



