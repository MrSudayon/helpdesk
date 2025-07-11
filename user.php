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
?>
	<title>Helpdesk</title>

	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>		
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
	<script src="js/general.js"></script>
	<script src="js/user.js"></script>
	<link rel="stylesheet" href="css/style.css" />
<?php include('inc/container.php');?>

<div class="container">	
	<div class="row home-sections">
	<img src="assets/Logo.png" style="height: 30px; margin: 20px 0;"></img>
	<?php include('menus.php'); ?>		
	</div> 
	
	<div class="panel-heading">
		<div class="row">
			<div class="col-md-10">
				<h3 class="panel-title"></h3>
			</div>
			<div class="col-md-2" align="right">
				<button type="button" name="add" id="addUser" class="btn btn-success btn-xs">Add New</button>
			</div>
		</div>
	</div>
			
	<table id="listUser" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>S/N</th>
				<th>Name</th>					
				<th>Username</th>
				<th>Department</th>
				<th>Created</th>
				<th>Role</th>
				<th>Status</th>
				<th></th>
				<th></th>				
			</tr>
		</thead>
	</table>
	
	<div id="userModal" class="modal fade">
		<div class="modal-dialog">
			<form method="post" id="userForm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add User</h4>
					</div>
					<div class="modal-body">
						<div class="form-group"
							<label for="userName" class="control-label">Name*</label>
							<input type="text" class="form-control" id="userName" name="userName" placeholder="User name" autocomplete="off" required>			
						</div>
						
						<div class="form-group"
							<label for="email" class="control-label">Username*</label>
							<input type="text" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off" required>			
						</div>
						
						<div class="form-group">
							<label for="departmentName" class="control-label">Department</label>				
							<select id="departmentName" name="departmentName" class="form-control" placeholder="Division...">					
								<?php $tickets->getDepartments(); ?>
							</select>							
						</div>	

						<div class="form-group">
							<label for="role" class="control-label">Role</label>				
							<select id="role" name="role" class="form-control">
								<option value="admin">Admin</option>				
								<option value="user">Member</option>	
							</select>						
						</div>	
						
						<div class="form-group">
							<label for="status" class="control-label">Status</label>				
							<select id="status" name="status" class="form-control">
							<option value="1">Active</option>				
							<option value="0">Inactive</option>	
							</select>						
						</div>

						<div class="form-group"
							<label for="username" class="control-label">New Password</label>
							<input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Password">			
						</div>											
						
					</div>
					<div class="modal-footer">
						<input type="hidden" name="userId" id="userId" />
						<input type="hidden" name="action" id="action" value="" />
						<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>	
<?php include('inc/footer.php');?>