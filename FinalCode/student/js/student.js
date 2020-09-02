$(document).ready(function(){
	var start = new Date();
	var end = new Date(new Date().setYear(start.getFullYear()+1));
	$('#appointment-date').datepicker({
		format: 'dd-mm-yyyy',
		startDate : start,
		endDate   : end,
		todayHighlight: true,
		autoclose: true,
	}).on('changeDate', function(){
		getData();
	}); 
	function getData(){ 
		let appointmentDate = $('#appointment-date').val();		
	  	let obj = {
			 'type':1,
			 'apointmentDate' : appointmentDate
		}
		$.ajax({
          type: "POST",
          url: 'studentAjax.php',
          data: obj,
          success: function(response) { 
          	   console.log(response);
	          	var result = $.parseJSON(response);
	          	$("#eky").val(result.encryptKey)
	    		var locHtml = '<option value="">---Select One---</option>';
	        	$.each(result.location, function(key,value) { 
	  				locHtml += '<option value="'+key+'">'+value+'</option>';	                    
				});
	            $("#student-location").html(locHtml);

				var reasonHtml = '<option value="">---Select One---</option>';
				$.each(result.reason, function(key,value) { 
					reasonHtml += '<option value="'+key+'">'+value+'</option>';	                    
				});
				$("#student-reason").html(reasonHtml);
			}
    	})
  }
  $('#student-location').change(function(){
  	let locType =  $("input[type='radio']:checked").val();
  	if(locType){
  		timSlotFn();
  	}  	
  });
  $('.interview_type').change(function(){ 
  	timSlotFn();
  });
  function timSlotFn(){
  	let appointmentDate = $('#appointment-date').val();	
  	if(!appointmentDate){
            $("#appointment-error").text("This field is required")
			return false;
	}
  	let locId = $('#student-location').val();
  	if(!locId){
  		$("#appointment-error").text("");
        $("#location-error").text("This field is required");
		return false;
	}
	 $("#location-error").text("");
  	let locType =  $("input[type='radio']:checked").val();
  	let obj = {
			 'type':2,
			 'apointmentDate' : appointmentDate,
			 'locId' : locId,
			 'loc_type':locType
		}	
	$.ajax({
          type: "POST",
          url: 'studentAjax.php',
          data: obj,
          success: function(response) { 
	          	var result = $.parseJSON(response);
	    		var breakTime = '<option value="">---Select One---</option>';
	        	$.each(result.timeSlot, function(key,value) { 
	  				breakTime += '<option value="'+key+'">'+value+'</option>';	                    
				});
	            $("#time-slot").html(breakTime);
			}
    	})
  }
})