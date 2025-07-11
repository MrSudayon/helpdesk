<?php 
include 'init.php';
if($users->isLoggedIn()) {
	header('Location: introduction.php');
}
$errorMessage = $users->login();
include('inc/header.php');
?>
<title>Helpdesk</title>
<link rel="stylesheet" href="css/style.css"/>
<?php include('inc/container.php');?>

<div class="container contact"><br>
	<div class="mainSubject">Login</div>	
	<div class="col-md-5">                    
		<div class="panel panel-info">
			<div class="panel-heading" style="background:#647484;color:white;font-weight:bold;">
				<div class="panel-title">User Login</div>                        
			</div> 
			<div style="padding-top:30px" class="panel-body" >
				<?php if ($errorMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
				<?php } ?>
				<form id="loginform" class="form-horizontal" role="form" method="POST" action="">                                    
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" class="form-control" id="email" name="email" placeholder="username" style="background:white;" autocomplete="on" required>                                        
					</div>                                
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" id="password" name="password"placeholder="password" required>
					</div>
					<div style="margin-top:10px" class="form-group">                               
						<div class="col-sm-12 controls">
						  <input type="submit" name="login" value="Login" class="btn btn-success">						  
						  <a href="register.php" class="link">Register</a>						  
						</div>						
					</div>	
				</form>   
			</div>                     
		</div>  
	</div>
</div>	
<div class="guide">
	<div class="mainSubject">Helpdesk FAQ</div>

	<ol class="lists">
		<li><b>Cannot log in:</b> If you already have an account but cannot sign in, please try using your corporate email as your username <b>without the email domain</b> (e.g, remove “@oxc-ph.com”). If you still cannot log in, reach us on Teams or email us at <a href="mailto:it-team@oxc-ph.com">it-team@oxc-ph.com</a> for assistance.</li>
		<li><b>How do I create an account?:</b> Creating an account on the Helpdesk system is simple. Upon accessing the Helpdesk, click the <b>‘Register’</b> link beside the <b>‘Login’</b> button. You will be redirected to the registration form, where you can fill in your account details to get started. <a href="assets/IT Helpdesk Guidelines.pdf" class="download" download>Guide PDF</a></li>	
		<li><b>Forgotten username or password:</b>  If you forget your username or password, please contact the IT Department or Helpdesk Administrator for assistance. A “Forgot Password” feature for resetting passwords will be available soon.</li>
		<li><b>How do I know the status of the ticket?:</b> After logging in, you can view your dashboard to check the status of your created tickets. You will see if your ticket is already resolved or still in progress. You can also open each ticket to view replies and suggestions from support regarding your concern.</li>
		<!-- <li><b>Urgency/Prioritization of the ticket:</b> TBA</li> -->
	</ol>
</div>

<?php include('inc/footer.php');?>