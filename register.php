<?php 
include 'init.php';
if($users->isLoggedIn()) {
	header('Location: ticket.php');
}

include('inc/header.php');
?>
	<title>Purchase Request System</title>
	<script type="text/javascript" src="js/register.js"></script>

<?php include('inc/container.php');?>
<div class="container contact">	
	<h2>Register</h2>	
	<div class="col-md-6">                    
		<div class="panel panel-info">
			<div class="panel-heading" style="background:#00796B;color:white;">
				<div class="panel-title">Register</div>                        
			</div> 
			<div style="padding-top:30px" class="panel-body" >

				<form id="registerform" class="form-horizontal" role="form" method="POST">              
                    <div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" class="form-control" id="name" name="name" placeholder="Fullname" style="background:white;" required>                                        
					</div>     

					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="email" class="form-control" id="email" name="email" placeholder="email" style="background:white;" required>                                        
					</div>                                

					<input type="hidden" id="role" name="role" value="user">                                        

					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" id="password" name="password"placeholder="password" required>
					</div>
                    <div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" id="cpassword" name="cpassword"placeholder="confirm password" required>
					</div>
					<div style="margin-top:10px" class="form-group">                               
						<div class="col-sm-12 controls">
							<input type="hidden" name="action" id="action" value="" />
						  	<!-- <input type="submit" name="register" id="register" value="Register" class="btn btn-success">						   -->
						  	<input type="submit" onclick="submitData('registerUser')" value="Register" class="btn btn-success">						  
						  	<a href="login.php" class="link">have an account already?</a>						  
						</div>						
					</div>	
				</form>   
			</div>                     
		</div>  
	</div>
</div>	
<?php include('inc/footer.php');?>