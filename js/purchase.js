// Add req form

$(document).ready(function() {     

    // $('#ticketReply').click(function(event){
	// 	event.preventDefault();
	// 	$('#reply').attr('disabled','disabled');
	// 	var formData = $(this).serialize();
	// 	$.ajax({
	// 		url:"ticket_action.php",
	// 		method:"POST",
	// 		data:formData,
	// 		success:function(data){				
	// 			$('#ticketReply')[0].reset();
	// 			$('#reply').attr('disabled', false);
	// 			location.reload();
	// 		}
	// 	})

	// var keepModalOpen = false;
	// var requestFormTemplate = $('#requestform').html();
	// var requestFormCount = 1;

	// $('#addRequestForm').on('click', function() {
	// 	var newRequestForm = $('<div class="asset-details">' + requestFormTemplate + '</div>');
	// 	$('.asset-details:last').after(newRequestForm);
	// 	requestFormCount++;
	// 	keepModalOpen = true;
	// });

	// $('#deleteRequestForm').on('click', function() {
	// 	if (requestFormCount > 1) {
	// 		$('.asset-details:last').remove();
	// 		requestFormCount--;
	// 	}
	// });
	
	// $('#purchaseModal').on('hide.bs.modal', function (e) {
	// 	if (keepModalOpen) {
	// 		e.preventDefault(); // Prevent the modal from closing
	// 		keepModalOpen = false; // Reset the flag
	// 	}
	// });

	$('#purchaseRequest').click(function(){
		$('#purchaseModal').modal('show');
		$('#purchaseForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Purchase Form");
		$('#action').val('purchaseRequest');
		$('#save').val('What');
	});

	if($('#listRequests').length) {
		var requestData = $('#listRequests').DataTable({
			"lengthChange": false,
			"processing":true,
			"serverSide":true,
			"order":[],
			"ajax":{
				url:"purchase_action.php",
				type:"POST",
				data:{action:'listRequests'},
				dataType:"json"
			},
			"columnDefs":[
				{
					"targets":[0, 10, 11, 12],
					"orderable":false,
				},
			],
			"paginate": true,
			"pageLength": 5
		});
		$(document).on('submit','#purchaseForm', function(event){
			event.preventDefault();
			$('#save').attr('disabled','disabled');
			var formData = $(this).serialize();
			$.ajax({
				url:"purchase_action.php",
				method:"POST",
				data:formData,
				success:function(data) {
					$('#purchaseForm')[0].reset();
					$('#purchaseModal').modal('hide');                
					$('#save').attr('disabled', false);
					requestData.ajax.reload();
				}
			})
		});
		
		// $(document).on('click', '.update', function(){
		// 	var ticketId = $(this).attr("id");
		// 	var action = 'getTicketDetails';
		// 	$.ajax({
		// 		url:'ticket_action.php',
		// 		method:"POST",
		// 		data:{ticketId:ticketId, action:action},
		// 		dataType:"json",
		// 		success:function(data){
		// 			$('#ticketModal').modal('show');
		// 			$('#ticketId').val(data.id);
		// 			$('#subject').val(data.title);
		// 			$('#message').val(data.init_msg);
		// 			if(data.gender == '0') {
		// 				$('#open').prop("checked", true);
		// 			} else if(data.gender == '1') {
		// 				$('#close').prop("checked", true);
		// 			}
		// 			$('.modal-title').html("<i class='fa fa-plus'></i> Edit Ticket");
		// 			$('#action').val('updateTicket');
		// 			$('#save').val('Save Ticket');
		// 		}
		// 	})
		// });			
		// $(document).on('click', '.delete', function(){
		// 	var ticketId = $(this).attr("id");		
		// 	var action = "closeTicket";
		// 	if(confirm("Are you sure you want to close this ticket?")) {
		// 		$.ajax({
		// 			url:"ticket_action.php",
		// 			method:"POST",
		// 			data:{ticketId:ticketId, action:action},
		// 			success:function(data) {					
		// 				ticketData.ajax.reload();
		// 			}
		// 		})
		// 	} else {
		// 		return false;
		// 	}
		// });	
    }
});

