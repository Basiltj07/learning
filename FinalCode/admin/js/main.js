$(document).ready(function(){
     
	var start = new Date();
	var end = new Date(new Date().setYear(start.getFullYear()+1));
   $('#end-date').datepicker({
		format:'dd-mm-yyyy',
		startDate : start,
		endDate   : end,
		autoclose: true,
	});
   
	$('#start-date').datepicker({
		format:'dd-mm-yyyy',
		startDate : start,
		endDate   : end,
		todayHighlight: true,
		autoclose: true,
	}).on('changeDate', function(){
		$('#end-date').datepicker('setDate',$(this).val());
	}); 
    
    $('#end-date1').datepicker({
		format:'dd-mm-yyyy',
		autoclose: true,
	});
   
	$('#start-date1').datepicker({
		format:'dd-mm-yyyy',
		todayHighlight: true,
		autoclose: true,
	})
    $('#end-date1').datepicker('setDate','today');
    $('#start-date1').datepicker('setDate','today');

	$('#loc_modal').click(function(){
		$('#title-modal').text('Add Location');
		var inputBody = '<label for="recipient-name" class="col-form-label">Location:</label><input type="text" class="form-control" name="new_location" id="new_location"><span id="error"></span><br/>';
		
		$('#inputBody').html(inputBody)
		$('.saveBtn').attr('id', 'location_btn');
	})
	$('#reason_modal').click(function(){
		$('#title-modal').text('Add Reason');
		var inputBody = '<label for="recipient-name" class="col-form-label">Reason:</label><input type="text" class="form-control" name="new_reason" id="new_reason"><span id="error"></span>';
		$('#inputBody').html(inputBody);
		$('.saveBtn').attr('id', 'reason_btn');
	})
	/*var inputEle = document.getElementById('timeInput');*/
	$('#start-time').wickedpicker();
	$('#end-time').wickedpicker();

	$('#time-gap').keyup(function() {
		let timeGap = $("#time-gap").val();
		if(timeGap.length > 1 && timeGap.length < 3){
			let obj = {
				'timeGap': $("#time-gap").val(),
				'startTime':$("#start-time").val(),
				'endTime':$("#end-time").val(),
			}
			$.ajax({
            type: "POST",
            url: 'timeSlotData.php',
            data: obj,
            success: function(response) { 
                //let response = '{"1":"8:42 pm-9:02 pm","2":"9:02 pm-9:22 pm","3":"9:22 pm-9:42 pm","4":"9:42 pm-10:02 pm","5":"10:02 pm-10:22 pm","6":"10:22 pm-10:42 pm"}';
                 var html = '';
                $.each($.parseJSON(response), function(key,value) {     
      				html += '<input type="checkbox" id="slot'+key+'"  name="slot[]" value="'+key+'"><label  for="slot'+key+'">'+value+'</label>';
	                if(key % 3 ==0){
	                	html +="<br/>";
	                }      
  				});
                $('#time-slot').html(html)
            }
       		})
		} else {
			console.log("Invalid input");
		}        
     });
	$(document).on('click','#location_btn',function(){

		var location = $("#new_location").val();
		if(!location){
            $("#error").text("This field is required")
			return false;
		}
		var update = $("#isEdit").val();
	
		let obj = {
				'location': location,
				'type':1
			}
			$.ajax({
	            type: "POST",
	            url: 'ajaxInsert.php',
	            data: obj,
            	success: function(response) { 
            		modalClose();
            		if(update === undefined){
            			getMultiSelectLocation();
            		} else {
            			window.location.reload();
            		}
            	}
        	})
		
	});
	$(document).on('click','#reason_btn',function(){
		var reason = $("#new_reason").val();
		if(!reason){
            $("#error").text("This field is required")
			return false;
		}
		var update = $("#isEdit").val();
		let obj = {
				'reason': reason,
				'type':2
			}
			$.ajax({
	            type: "POST",
	            url: 'ajaxInsert.php',
	            data: obj,
            	success: function(response) { 
            		modalClose();
            		if(update === undefined){
            			getMultiSelectReason();
            		} else {
            			window.location.reload();
            		}
            	}
        	})

	});
	
  function modalClose(){
	$("body").removeClass("modal-open");
	$(".modal-backdrop").remove();
	$("#commonModal").hide();
  }
  getMultiSelectLocation();
  getMultiSelectReason();
  function getMultiSelectLocation(){
  	let obj = {
		 'type':1
		}
		$.ajax({
          type: "POST",
          url: 'ajaxLookup.php',
          data: obj,
          success: function(response) { 
	        	var locType = '';
	        	$.each($.parseJSON(response), function(key,value) { 
	  				locType += '<option value="'+key+'">'+value+'</option>';	                    
				});
	            $("#location").html(locType);
        	}
    	})
  }
  function getMultiSelectReason(){
  	let obj = {
		 'type':2
		}
		$.ajax({
          type: "POST",
          url: 'ajaxLookup.php',
          data: obj,
          success: function(response) { 
        		var reason = '';
        		$.each($.parseJSON(response), function(key,value) { 
  					reason += '<option value="'+key+'">'+value+'</option>';	                    
					});
             $("#reason").html(reason);
        	}
    	})
  } 
  $('#search-data').click(function(){
  	getBookingData();
  })
  function getBookingData(){
  	let startDate = $("#start-date1").val();
  	let endDate = $("#end-date1").val();

  	let obj = {
  		startDate:startDate,
  		endDate:endDate
  	}
  	$.ajax({
          type: "POST",
          url: 'studentTable.php',
          data: obj,
          success: function(response) { 
        		var reason = '';
        		
             $("#table-data").html(response);
        	}
    	})
  }
  $('.trainer-action').change(function(){
  	var stateValue = $('.trainer-action').val();
  	var bid = $(this).attr("data-id");
  	if(stateValue !=2){
  		$('#title-modal').text('Content');
		var inputBody = '<label for="text-content" class="col-form-label">Content:</label><textarea class="form-control" name="content" id="text-content" rows="10" cols="50"> </textarea><span id="error" class="error"></span><br/>';
		inputBody +='<input type="hidden" name="bookid" id="bid" value="'+bid+'"/>'
		$('#inputBody').html(inputBody)
		$('.saveBtn').attr('id', 'saveBtn'+stateValue);
		$("body").addClass("modal-open");
	  	$("#commonModal").addClass('show');
	  	$("#commonModal").css({"padding-right": "15px", "display": "block"});
  	} else {
		let obj = {
			bookId:bid,
			type:2
		}
		$.ajax({
			type: "POST",
			url: 'trainerUpdate.php',
			data: obj,
			success: function(response) { 
				document.location="appointmentList.php";
			}
		})
  	}
  });
  $('.modal-cls').click(function(){
  	modalClose();
  })
  $(document).on('click','#saveBtn0',function(){
  	let content = $('#text-content').val();
  	if(!$.trim($("#text-content").val())){
  		$('#error').html('This field is required');
  		return false;
  	} 
  	let bookingId = $('#bid').val();
  	let obj = {
  		bookId:bookingId,
  		content:content,
  		type:0
  	}
  	$.ajax({
          type: "POST",
          url: 'trainerUpdate.php',
          data: obj,
          success: function(result) { 
            var response = $.parseJSON(result);
            if(response.status ==1){
              document.location="appointmentList.php";
            }
        	}
    	})
  	
  });
  $(document).on('click','#saveBtn1',function(){
  	let content = $('#text-content').val();
  	if(!$.trim($("#text-content").val())){
  		$('#error').html('This field is required');
  		return false;
  	}
  	let bookingId = $('#bid').val();
  	let obj = {
  		bookId:bookingId,
  		content:content,
  		type:1
  	}
  	$.ajax({
          type: "POST",
          url: 'trainerUpdate.php',
          data: obj,
          success: function(result) { 
            var response = $.parseJSON(result);
            if(response.status ==1){
              document.location="appointmentList.php";
            }
          }
    })
  })
})