<?php 
include 'init.php'; 
if(!$users->isLoggedIn()) {
	header("Location: login.php");	
}
include('inc/header.php');
$user = $users->getUserInfo();
?>
<title>Purchase Request System</title>
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
	<h2>Purchase Request System</h2>	
	<?php include('menus.php'); ?>		
	</div> 
	<div class="">   		
		<!-- Ticket Counts -->
		<div class="ticketCounts">
			<?php if(isset($_SESSION["admin"])) { ?>
			<div class="count">All Requests: <h1><?php echo $database->allTicketCount(); ?></h1></div>
			<!-- <div class="count">New Tickets: <h1>\</h1></div> -->
			<div class="count">Open Requests: <h1><?php echo $database->openTicketCount(); ?></h1></div>
			<div class="count">Closed Requests: <h1><?php echo $database->closedTicketCount(); ?></h1></div>
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
		

		<table id="listRequests" class="table table-bordered table-striped">	
			<thead>
				<tr>
					<th>S/N</th>
					<th>Purchase ID</th>
					<th>Subject</th>
					<th>Requested By</th>
					<th>Endorsed By</th>
					<th>Department</th>
					<th>Amount</th>					
					<th>Date Created</th>	
					<th>Date Needed</th>	
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