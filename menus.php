<nav class="navbar navbar-inverse" style="background:#00796B;color:#f6f8f9;font-weight:bold;">
	<div class="container-fluid">		
		<ul class="nav navbar-nav menus">
			<li id="ticket"><a href="ticket.php" class="navbar-brand">Ticket</a></li>
			<li id="ticket"><a href="purchase_requests.php" >Purchase Form</a></li>
			<!-- <li id="purchase"><a href="department.php"></a></li> -->
			<?php if(isset($_SESSION["admin"])) { ?>
				<li id="department"><a href="department.php" >Department</a></li>
				<li id="user"><a href="user.php" >Users</a></li>				
			<?php } ?>						
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> 
				<img src="//gravatar.com/avatar/<?php echo md5($user['email']); ?>?s=100" width="20px">&nbsp;<?php if(isset($_SESSION["userid"])) { echo $user['name']; } ?></a>
				<ul class="dropdown-menu">					
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>