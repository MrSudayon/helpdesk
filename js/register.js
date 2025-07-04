function submitData(action) {
	$(document).ready(function() {
		var data = {
            action: action,
            name: $('#name').val(),
            email: $('#email').val(),
            department: $('#departmentName').val(),
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

