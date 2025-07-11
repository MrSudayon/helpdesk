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
$_SESSION['LAST_ACTIVITY'] = time();

include('inc/header.php');
$user = $users->getUserInfo();
$ticket = $tickets->getTicketDetails();
?>
<title>Helpdesk</title>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/general.js"></script>
<link rel="stylesheet" href="css/style.css" />
<div class="container">	
	<div class="row home-sections">
	<img src="assets/Logo.png" style="height: 30px; margin: 20px 0;"></img>
	<?php include('menus.php'); ?>		
	</div> 
	<div class="">   		
		<!-- Ticket Counts -->
		<div class="ticketCounts">
			<?php if(isset($_SESSION["admin"])) { ?>
			<div class="count">All Tickets: <h1><?php echo $database->allTicketCount(); ?></h1></div>
			<!-- <div class="count">New Tickets: <h1>\</h1></div> -->
			<div class="count">Open Tickets: <h1><?php echo $database->openTicketCount(); ?></h1></div>
			<div class="count">Closed Tickets: <h1><?php echo $database->closedTicketCount(); ?></h1></div>
			<?php } ?>
		</div>
			
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-12" align="right">
					<!-- <button type="button" name="req" id="purchaseRequest" class="btn btn-success btn-xs">Purchase Request</button> -->
					<button type="button" name="add" id="createTicket" class="btn btn-success btn-xs">Create Ticket</button>
				</div>
			</div>
		</div>
		<table id="listTickets" class="table table-bordered table-striped">	
			<thead>
				<tr>
					<th>S/N</th>
					<th>Ticket ID</th>
					<th style="width: 100%;">Subject</th>
					<th>Division</th>
					<?php if(isset($_SESSION["admin"])) { ?>
						<th>Requested by</th>		
					<?php } ?>
					<th>Created By</th>					
					<th>Created</th>	
					<th>Status</th>
					<th>Duration</th>
					<th></th>
					<th></th>
					<th></th>					
				</tr>
			</thead>
		</table>
	</div>
	<script>
		// Expose session role to JavaScript
		window.sessionId = "<?php echo $user["id"]; ?>";
		window.department = "<?php echo $user["department"]; ?>";
		window.sessionRole = "<?php echo $user["user_type"]; ?>";
	</script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="js/tickets.js"></script>
	<?php include('add_ticket_model.php'); ?>
	 <!-- include('add_purchase_model.php');  -->
</div>	
<?php include('inc/footer.php');?>