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
	$('#purchaseRequest').click(function(){
		$('#purchaseModal').modal('show');
		$('#purchaseForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Purchase Form");
		$('#action').val('purchaseRequest');
		$('#save').val('What');
	});	
	// $('#purchaseModal').on('hide.bs.modal', function (e) {
	// 	if (keepModalOpen) {
	// 		e.preventDefault(); // Prevent the modal from closing
	// 		keepModalOpen = false; // Reset the flag
	// 	}
	// });
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
	

	

	$(document).on('submit','#purchaseForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"purchase_action.php",
			method:"POST",
			data:formData,
			success:function(data){                
				$('#purchaseForm')[0].reset();
				$('#purchaseModal').modal('hide');                
				$('#save').attr('disabled', false);
				// ticketData.ajax.reload();
			}
		})
	}); 
	// if($('#listTickets').length) {
	// 	var ticketData = $('#listTickets').DataTable({
	// 		"lengthChange": false,
	// 		"processing":true,
	// 		"serverSide":true,
	// 		"order":[],
	// 		"ajax":{
	// 			url:"ticket_action.php",
	// 			type:"POST",
	// 			data:{action:'listTicket'},
	// 			dataType:"json"
	// 		},
	// 		"columnDefs":[
	// 			{
	// 				"targets":[0, 6, 7, 8, 9],
	// 				"orderable":false,
	// 			},
	// 		],
	// 		"pageLength": 10
	// 	});			
	

	// $(document).on('submit','#purchaseForm', function(event){
	// 	event.preventDefault();
	// 	$('#save').attr('disabled','disabled');
	// 	var formData = $(this).serialize();
	// 	$.ajax({
	// 		url:"purchase_action.php",
	// 		method:"POST",
	// 		data:formData,
	// 		success:function(data){				
	// 			$('#purchaseForm')[0].reset();
	// 			$('#purchaseModal').modal('hide');				
	// 			$('#save').attr('disabled', false);
	// 			ticketData.ajax.reload();
	// 		}
	// 	})
	// });			
});

