

$("#save-schedule").click(function(){
	if(validatorFn()){
		$("#admin-save").submit();
	} 
});

function validatorFn(){ 
	var startDate = $('#start-date').val();
	var endDate = $('#end-date').val();
	var startTime = $('#start-time').val();
	var endTime = $('#end-time').val();
	var timeGap = $('#time-gap').val();
	var location = $('#location').val();
	var reason = $('#reason').val();
	console.log(startDate,endDate,startTime,endTime,timeGap,location,reason);
    if(startDate === ''){
		$("#startdate-error").text("This field is required");
		return false;
	} else if(endDate ===''){
		$("#startdate-error").text("");
		$("#enddate-error").text("This field is required");
		return false;
	} else if(startTime === ''){
		$("#enddate-error").text("");
		$("#starttime-error").text("This field is required");
		return false;
	} else if(endTime === ''){
		$("#starttime-error").text("");
		$("#endtime-error").text("This field is required");
		return false;
	} else if(timeGap === ''){
		$("#endtime-error").text("");
		$("#timegap-error").text("This field is required");
		return false;
	} else if(location.length===0){
		$("#timegap-error").text("");
		$("#location-error").text("This field is required");
		return false;
	} else if(reason.length === 0){
		$("#location-error").text("");
		$("#reason-error").text("This field is required");
		return false;
	} else{
		$("#reason-error").text("");
		return true;
	}
}