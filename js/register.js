$(document).ready(function() {        

	$('#registerform').submit(function() {
        var action = 'registerUser';
		var name = $('#name').val();
        var email = $('#email').val();
        var role = $('#role').val();
        var password = $('#password').val();
        var cpassword = $('#cpassword').val();
        $.ajax({
                url: 'user_action.php',
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    role: role,
                    password: password,
                    cpassword: cpassword, 
                    action:action	
                },
                cache: false,
                success: function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode==200){
                        $('#registerform').find('input:text').val('');
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                        $('#role').val(data.role);
                        $('#password').val(data.password);		
                        $('#cpassword').val(data.cpassword);		
                        $("#success").show();
                        $('#success').html('New user added successfully !'); 	
                        $('#action').val('registerUser');
                    }
                    else if(dataResult.statusCode==201){
                        alert("Error occured !");
                    }
                }
        });
	});		
    
	
			
});

