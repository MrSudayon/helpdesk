<?php 
include 'init.php'; 
if(!$users->isLoggedIn()) {
	header("Location: login.php");	
}
include('inc/header.php');
$user = $users->getUserInfo();
?>
<title>Helpdesk System</title>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>		
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/general.js"></script>
<script src="js/tickets.js"></script>
<script src="js/purchase.js"></script>
<link rel="stylesheet" href="css/style.css" />
<?php include('inc/container.php');?>
<div class="container">	
	<div class="row home-sections">
	<h2>Helpdesk System</h2>	
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
					<button type="button" name="req" id="purchaseRequest" class="btn btn-success btn-xs">Purchase Request</button>
					<button type="button" name="add" id="createTicket" class="btn btn-success btn-xs">Create Ticket</button>
				</div>
			</div>
		</div>
		

		<table id="listTickets" class="table table-bordered table-striped">	
			<thead>
				<tr>
					<th>S/N</th>
					<th>Ticket ID</th>
					<th>Subject</th>
					<th>Department</th>
					<th>Created By</th>					
					<th>Created</th>	
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>					
				</tr>
			</thead>
		</table>
	</div>
	<?php include('add_ticket_model.php'); ?>
	<?php include('add_purchase_model.php'); ?>
</div>	
<?php include('inc/footer.php');?>