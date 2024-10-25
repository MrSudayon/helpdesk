$(document).ready(function() {     
    $(document).on('submit','#ticketReply', function(event){
		event.preventDefault();
		$('#reply').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"ticket_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#ticketReply')[0].reset();
				$('#reply').attr('disabled', false);
				location.reload();
			}
		})
	});		
	$('#createTicket').click(function(){
		$('#ticketModal').modal('show');
		$('#ticketForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Create Ticket");
		$('#action').val('createTicket');
		$('#save').val('Save Ticket');
	});	


	// if($('#listTickets').length) {
	// ($('#listTickets').length) {
	// 	var ticketData = $('#listTickets').DataTable({
	// 		"searching": true,
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
	// 				"targets":[8, 9, 10],
	// 				"orderable":false,
	// 			},
	// 		],
	// 		"paginate": true,
	// 		"pageLength": 5
	// 	});			



	if ($('#listTickets').length) {
		var ticketData = $('#listTickets').DataTable({
			"searching": true,
			"lengthChange": true,  // Enables the page length dropdown
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "ticket_action.php",
				type: "POST",
				data: { action: 'listTicket' },
				dataType: "json"
			},
			"columnDefs": [
				{
					"targets": [9, 10, 11],
					"orderable": false,  // Prevents ordering on these columns
				},
			],
			"paginate": true,
			"pageLength": 10,  // Default number of rows per page
			"lengthMenu": [10, 25, 50, 100],  // Options for the user to select
		});
		$(document).on('submit','#ticketForm', function(event){
			event.preventDefault();
			$('#save').attr('disabled','disabled');
			var formData = $(this).serialize();
			$.ajax({
				url:"ticket_action.php",
				method:"POST",
				data:formData,
				success:function(data){
					$('#ticketForm')[0].reset();
					$('#ticketModal').modal('hide');				
					$('#save').attr('disabled', false);
					ticketData.ajax.reload();
				}
			})
		});			
		$(document).on('click', '.update', function(){
			var ticketId = $(this).attr("id");
			var action = 'getTicketDetails';
			$.ajax({
				url:'ticket_action.php',
				method:"POST",
				data:{ticketId:ticketId, action:action},
				dataType:"json",
				success:function(data){
					console.log(data);
					$('#ticketModal').modal('show');
					$('#ticketId').val(data.id);
					$('#name').val(data.createdfor);
					$('#subjectName').val(data.title);
					$('#departmentName').val(data.department);
					$('#message').val(data.init_msg);
					if(data.resolved == '0') {
						$('#open').prop("checked", true);
					} else if(data.resolved == '1') {
						$('#close').prop("checked", true);
					}
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Ticket");
					$('#action').val('updateTicket');
					$('#save').val('Save Ticket');
				}
			})
		});			
		$(document).on('click', '.delete', function(){
			var ticketId = $(this).attr("id");		
			var action = "closeTicket";
			if(confirm("Are you sure you want to close this ticket?")) {
				$.ajax({
					url:"ticket_action.php",
					method:"POST",
					data:{ticketId:ticketId, action:action},
					success:function(data) {					
						ticketData.ajax.reload();
					}
				})
			} else {
				return false;
			}
		});	
    }
});

