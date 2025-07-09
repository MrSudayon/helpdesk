<!--
Page changes for this feature:
introduction.php#
tutorial.php#
menus.php
general.js#
style.css#
Users.php#
user.js#
user.php#
index.php#


fixed bug on:
tickets.js#
add_ticket_model.php#
ticket.php #
subject.php#
department.php#
login.php#
register.php#

Pages changes for user account/department feature:
user_action.php#
Users.php#
user.php#
user.js#
Tickets.php#
ticket.php#
menus.php
register.js#
register.php#
-->

<?php 
include 'init.php';

if(!$users->isLoggedIn()) {
	header("Location: login.php");	
}

if (isset($_SESSION['LAST_ACTIVITY']) && 
    (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.php"); // redirect to login
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

include('inc/header.php');
$user = $users->getUserInfo();
?>


	<title>Helpdesk</title>

	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>		
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
	<script src="js/general.js"></script>
	<script src="js/subject.js"></script>
	<!-- <script src="js/department.js"></script> -->
	<link rel="stylesheet" href="css/style.css"/>
<?php include('inc/container.php'); ?>

<div class="container">	
	<div class="row home-sections">
		<!-- <h2>Introduction</h2>	 -->
		<img src="assets/Logo.png" style="height: 30px; margin: 20px 0;"></img>
		<?php include('menus.php'); ?>		
	</div> 

    <h3>Welcome to the Oxychem Help Desk!</h3>
<p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We’re here to support you with any technical concerns or general inquiries.
Reach us anytime via email at it-team@oxc-ph.com, or submit a ticket.<br>
Your ease is our priority—let’s solve it together!</p><br>
    <div class="mainSubject"> Helpdesk Flowchart </div>

    <br>
    <img src="assets/Helpdesk.png" style="margin: auto; display: block; width: 80%;"></img>	

</div>	
<?php include('inc/footer.php');?>