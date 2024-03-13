// $(document).ready(function() {        

	// $('#registerform').submit(function() {
	// 	var name = $('#name').val();
    //     var email = $('#email').val();
    //     var role = $('#role').val();
    //     var password = $('#password').val();
    //     var cpassword = $('#cpassword').val();
    //     $.ajax({
    //             url: 'user_action.php',
    //             type: "POST",
    //             data: {
    //                 name: name,
    //                 email: email,
    //                 role: role,
    //                 password: password,
    //                 cpassword: cpassword
    //             },
    //             cache: false,
    //             success: function(data){
    //                 var dataResult = JSON.parse(data);
    //                 if(dataResult.statusCode==200){
    //                     $('#registerform').find('input:text').val('');
    //                     $("#success").show();
    //                     $('#success').html('New user added successfully !'); 	
    //                     $('#action').val('registerUser');
    //                 }
    //                 else if(dataResult.statusCode==201){
    //                     alert("Error occured !");
    //                 }
    //             }
    //     });
	// });		
    // $(document).on('submit','#registerform', function(event){
	// 	event.preventDefault();
	// 	$('#register').attr('disabled','disabled');
	// 	var formData = $(this).serialize();
	// 	$.ajax({
	// 		url:"user_action.php",
	// 		method:"POST",
	// 		data:formData,
	// 		success:function(data){				
	// 			$('#registerform')[0].reset();
	// 			$('#register').attr('disabled', false);
	// 		}
	// 	})
	// });		
	// });		

function submitData(action) {
	$(document).ready(function() {
		var data = {
            action: action,
            name: $('#name').val(),
            email: $('#email').val(),
            role: $('#role').val(),
            pass: $('#password').val(),
            cpass: $('#cpassword').val(),
        };

        $.ajax({
                url: 'user_action.php',
                type: 'post',
                data: data ,
                success: function(response){
                    alert(response);
                }
        });
	});		
}

