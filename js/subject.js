$(document).ready(function() {        
	
	var subjectData = $('#listSubject').DataTable({
		"searching": true,
		"processing":true,
		"serverSide":true,
		"ajax":{
			url:"subject_action.php",
			type:"POST",
			data:{action:'listSubject'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[2,3],
				"orderable":false,
			},
		],
		"paginate": true,
		"pageLength": 5,
    	"lengthMenu": [3, 10, 25, 50, 100]
	});	


	$(document).on('click', '.update', function(){
		var subjectId = $(this).attr("id");
		var action = 'getSubjectDetails';
		$.ajax({
			url:'subject_action.php',
			method:"POST",
			data:{subjectId:subjectId, action:action},
			dataType:"json",
			success:function(data){
				$('#subjectModal').modal('show');
				$('#subjectId').val(data.id);
				$('#subjName').val(data.name);
				$('#status').val(data.status);				
				$('.modal-title').html("<i class='fa fa-plus'></i> Edit Subject");
				$('#action').val('updateSubject');
				$('#save').val('Save');
			}
		})
	});		
	
	$('#addSubject').click(function(){
		$('#subjectModal').modal('show');
		$('#subjectForm')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> Add subject");
		$('#action').val('addSubject');
		$('#save').val('Save');
	});	
		
	$(document).on('submit','#subjectForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled'); 
		var formData = $(this).serialize();
		$.ajax({
			url:"subject_action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#subjectForm')[0].reset();
				$('#subjectModal').modal('hide');				
				$('#save').attr('disabled', false);
				subjectData.ajax.reload();
			}
		})
	});			
			
	$(document).on('click', '.delete', function(){
		var subjectId = $(this).attr("id");		
		var action = "deleteSubject";
		if(confirm("Are you sure you want to delete this record?")) {
			$.ajax({
				url:"subject_action.php",
				method:"POST",
				data:{subjectId:subjectId, action:action},
				success:function(data) {					
					subjectData.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
    
});

