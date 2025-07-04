<!-- <nav class="navbar navbar-inverse" style="background:#00796B;color:#f6f8f9;font-weight:bold;"> -->
<nav class="navbar navbar-inverse" style="background:#647484;color:white;font-weight:bold;">
	<div class="container-fluid">		
		<ul class="nav navbar-nav menus">
			<li id="introduction"><a href="introduction.php" class="navbar-brand">Intro</a></li>
			<li id="tutorial"><a href="tutorial.php">Tutorials</a></li>

			<li id="ticket"><a href="ticket.php">Ticket</a></li>
			<?php if(isset($_SESSION["admin"])) { ?>
				<li id="subject"><a href="subject.php" >Subject</a></li>
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