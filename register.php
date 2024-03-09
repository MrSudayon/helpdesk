<?php 
include 'init.php';
if($users->isLoggedIn()) {
	header('Location: ticket.php');
}
$errorMessage = $users->login();
include('inc/header.php');
?>
<title>Helpdesk System</title>
<?php include('inc/container.php');?>
<div class="container contact">	
	<h2>Helpdesk System</h2>	
	<div class="col-md-6">                    
		<div class="panel panel-info">
			<div class="panel-heading" style="background:#00796B;color:white;">
				<div class="panel-title">Register</div>                        
			</div> 
			<div style="padding-top:30px" class="panel-body" >
				<?php if ($errorMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
				<?php } ?>
				<form id="loginform" class="form-horizontal" role="form" method="POST" action="">              
                    <div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" class="form-control" id="name" name="name" placeholder="Fullname" style="background:white;" required>                                        
					</div>     

					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input type="text" class="form-control" id="email" name="email" placeholder="email" style="background:white;" required>                                        
					</div>                                
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
						  <input type="submit" name="register" value="Register" class="btn btn-success">						  
						  <a href="login.php" class="link">have an account already?</a>						  
						</div>						
					</div>	
					<!-- <div style="margin-top:10px" class="form-group">                               
						<div class="col-sm-12 controls">
							Demo accounts<br>
						Admin: ezekiel@oxc.com<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;sudayon@oxc.com<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;password:123123	<br><br>
						User: smith@webdamn.com<br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;password:123							
						</div>						
					</div>	 -->
				</form>   
			</div>                     
		</div>  
	</div>
</div>	
<?php include('inc/footer.php');?>