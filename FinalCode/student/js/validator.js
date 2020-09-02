$("#save-btn").click(function(){
	if(validatorFn()){
		isExist();
	} 
});

function validatorFn(){ 
	var appointmentDate = $('#appointment-date').val();
	var studentLocation = $('#student-location').val();
	var studentTimeslot = $('#time-slot').val();
	var studentReason = $('#student-reason').val();
	var studentName = $('#student-name').val();
	var studentMobile = $('#student-mobile').val();
	var studentEmail = $('#student-email').val();
	var studentNumber = $('#student-number').val();
	if(appointmentDate===''){
		$("#appointment-error").text("This field is required");
		return false;
	} else if (studentLocation==='') {
		$("#appointment-error").text('');
		$("#location-error").text("This field is required");
		return false;
	} else if(studentTimeslot===''){
		$("#location-error").text('');
		$("#timeslot-error").text("This field is required");
		return false;
	} else if(studentReason===''){
		$("#timeslot-error").text('');
		$("#reason-error").text("This field is required");
		return false;
	}else if(studentName==='') {
		$("#reason-error").text('');
		$("#name-error").text("This field is required");
		return false;
	} else if(studentMobile==='') {
		$("#name-error").text('');
		$("#mobile-error").text("This field is required");
		return false;
	} else if(studentEmail==='') {
		$("#mobile-error").text('');
		$("#email-error").text("This field is required");
		return false;
	}else if(studentNumber ==='') {		
		$("#email-error").text('');
		$("#number-error").text("This field is required");
		return false;
	} else {
		return true;
	}
}
function isExist(){
	let appointmentDate = $('#appointment-date').val();		
	let locId = $('#student-location').val();
	let timeSlot = $('#time-slot').val();
	let flag = false;
	  	let obj = {
			 'type':4,
			 'apointmentDate' : appointmentDate,
			 'timeSlot':timeSlot,
			 'locId':locId,
		}
		$.ajax({
          type: "POST",
          url: 'studentAjax.php',
          data: obj, 
          success: function(result) { 
				var response = $.parseJSON(result);
				if(response.status == 0){
					$('#error-booking').text(response.msg);
				} else{
					ajaxValidator();
				}
			}         
    	});    	
        return flag;
}
function ajaxValidator(){ 
	let appointmentDate = $('#appointment-date').val();		
	let reasonId = $('#student-reason').val();		
	//let studentId = $('#student-number').val();
	let studentEmail = $('#student-email').val();
	  	let obj = {
			 'type':3,
			 'apointmentDate' : appointmentDate,
			 'studentEmail':studentEmail,
			 'reasonId':reasonId
		}
		$.ajax({
          type: "POST",
          url: 'studentAjax.php',
          data: obj          
    	}).done(function( msg ) {
    		var response = $.parseJSON(msg);
    		if(response.status == 0){
    			$('#error-booking').text(response.msg);
    			return false;
    		} else{
    			$("#savestudent").submit();
    		}
        });
}