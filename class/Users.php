<?php
class Users extends Database { 
	private $userTable = 'hd_users';
	private $dbConnect = false;
	public function __construct(){		
        $this->dbConnect = $this->dbConnect();
    }	
	public function isLoggedIn () {
		if(isset($_SESSION["userid"])) {
			return true; 			
		} else {
			return false;
		}
	}
	public function login(){		
		$errorMessage = '';
		if(!empty($_POST["login"]) && $_POST["email"]!=''&& $_POST["password"]!='') {	
			$email = $_POST['email'];
			$password = $_POST['password'];
			$sqlQuery = "SELECT * FROM ".$this->userTable." 
				WHERE email='".$email."' AND password='".md5($password)."' AND status = 1";
				
			$resultSet = mysqli_query($this->dbConnect, $sqlQuery);
			$isValidLogin = mysqli_num_rows($resultSet);	
			if($isValidLogin){
				$userDetails = mysqli_fetch_assoc($resultSet);
				$_SESSION["userid"] = $userDetails['id'];
				$_SESSION["user_name"] = $userDetails['name'];
				$_SESSION["user_type"] = $userDetails['user_type'];
				if($userDetails['user_type'] == 'admin') {
					$_SESSION["admin"] = 1;
				}
				header("location: ticket.php"); 		
			} else {		
				$errorMessage = "Invalid login!";		 
			}
		} else if(!empty($_POST["login"])){
			$errorMessage = "Enter Both user and password!";	
		}
		return $errorMessage; 		
	}
	public function registerUser() { // Registers user role only
		 
		if($_POST["name"] && $_POST["email"]) {

			$name = $_POST["name"];
			$email = $_POST["email"];
			$role = $_POST["role"];
			$password = $_POST["pass"];
			$confirm = $_POST["cpass"];  

			$name = strip_tags($name);			
			$email = strip_tags($email);	

			$selectUser = "SELECT * FROM ".$this->userTable." WHERE name = ? AND email = ?";
			$stmt = $this->dbConnect->prepare($selectUser);
			$stmt->bind_param("ss", $name, $email);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				// Record exists
				echo "Record already exists!";
			} else {
				if($password == $confirm) {
					$password = md5($password);	
	
					$queryInsert = "
						INSERT INTO ".$this->userTable." (name, email, password, user_type, status) VALUES(
						'$name', '$email', '$password', '$role','1')";				
					mysqli_query($this->dbConnect, $queryInsert);	
					
					echo "Registered Successfully";
				} else {
					echo "Password does not match";
				}
			} 
		}
	}

	public function getUserInfo() {
		if(!empty($_SESSION["userid"])) {
			$sqlQuery = "SELECT name, email, create_date, user_type, status FROM ".$this->userTable." 
				WHERE id ='".$_SESSION["userid"]."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);		
			$userDetails = mysqli_fetch_assoc($result);
			return $userDetails;
		}		
	}
	public function getColoumn($id, $column) {     
        $sqlQuery = "SELECT * FROM ".$this->userTable." 
			WHERE id ='".$id."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);		
		$userDetails = mysqli_fetch_assoc($result);
		return $userDetails[$column];       
    }
	
	
	public function listUser1(){
		
		$sqlQuery = "SELECT * FROM ".$this->userTable;
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' (name LIKE "%'.$_POST["search"]["value"].'%" ';					
			$sqlQuery .= ' OR email LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR create_date LIKE "%'.$_POST["search"]["value"].'%" ';					
		}
		if(!empty($_POST["order"])){

			$orderColumnIndex = $_POST['order']['0']['column'];
			$orderColumnName = $_POST['columns'][$orderColumnIndex]['data'];

			if ($orderColumnName == '1' || $orderColumnName == 'name') {
				$sqlQuery .= ' ORDER BY name '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '2' || $orderColumnName == 'email') {
				$sqlQuery .= ' ORDER BY email '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '3' || $orderColumnName == 'create_date') {
				$sqlQuery .= ' ORDER BY create_date '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '4' || $orderColumnName == 'user_type') {
				$sqlQuery .= ' ORDER BY user_type '.$_POST['order']['0']['dir'].' ';
			}
			elseif ($orderColumnName == '5' || $orderColumnName == 'status') {
				$sqlQuery .= ' ORDER BY status '.$_POST['order']['0']['dir'].' ';
			}
			
		} else {
			$sqlQuery .= ' ORDER BY status DESC ';
		}

		if($_POST["length"] != -1){
			$sqlQuery .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST["length"];
		}	
		
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$userData = array();	
		while( $user = mysqli_fetch_assoc($result) ) {		
			$userRows = array();			
			$status = '';
			if($user['status'] == 1) {
				$status = '<span class="label label-success">Active</span>';
			} elseif($user['status'] == 0) {
				$status = '<span class="label label-danger">Inactive</span>';
			}	
			
			$userRole = '';
			if($user['user_type'] == 'admin')	{	
				$userRole = '<span class="label label-danger">Admin</span>';
			} elseif($user['user_type'] == 'approver1') {
				$userRole = '<span class="label label-success">Approver</span>';
			} elseif($user['user_type'] == 'approver2') {
				$userRole = '<span class="label label-primary">Final Approver</span>';
			} elseif($user['user_type'] == 'user') {
				$userRole = '<span class="label label-default">Member</span>';
			}	
			
			$userRows[] = $user['id'];
			$userRows[] = $user['name'];
			$userRows[] = $user['email'];
			$userRows[] = $user['create_date'];
			$userRows[] = $userRole;			
			$userRows[] = $status;
				
			$userRows[] = '<button type="button" name="update" id="'.$user["id"].'" class="btn btn-warning btn-xs update">Edit</button>';
			$userRows[] = '<button type="button" name="delete" id="'.$user["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
			$userData[] = $userRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$userData
		);
		echo json_encode($output);
	}	

	public function listUser() {
		$start = $_POST['start'] ?? 0;  // Start index for pagination
		$length = $_POST['length'] ?? 10;  // Number of records per page
	
		// Query to get total number of records without filters
		$totalQuery = "SELECT COUNT(*) AS total FROM " . $this->userTable;
		$totalResult = mysqli_query($this->dbConnect, $totalQuery);
		$totalRecords = mysqli_fetch_assoc($totalResult)['total'];
	
		// Build the main query with search filter if applicable
		$sqlQuery = "SELECT * FROM " . $this->userTable;
	
		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' WHERE id LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR name LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR email LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR create_date LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR user_type LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR status LIKE "%' . $_POST["search"]["value"] . '%" ';
		}
	
		// Execute the filtered query to get the number of filtered records
		$filteredResult = mysqli_query($this->dbConnect, $sqlQuery);
		$filteredRecords = mysqli_num_rows($filteredResult);
	
		// Add ORDER BY clause for sorting
		if(!empty($_POST["order"])){

			$orderColumnIndex = $_POST['order']['0']['column'];
			$orderColumnName = $_POST['columns'][$orderColumnIndex]['data'];

			if ($orderColumnName == '1' || $orderColumnName == 'name') {
				$sqlQuery .= ' ORDER BY name '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '2' || $orderColumnName == 'status') {
				$sqlQuery .= ' ORDER BY email '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '3' || $orderColumnName == 'status') {
				$sqlQuery .= ' ORDER BY create_date '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '4' || $orderColumnName == 'status') {
				$sqlQuery .= ' ORDER BY user_type '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '5' || $orderColumnName == 'status') {
				$sqlQuery .= ' ORDER BY status '.$_POST['order']['0']['dir'].' ';
			} 

		} else {
			$sqlQuery .= ' ORDER BY status DESC ';
		}
	
		// Add LIMIT clause for pagination
		$sqlQuery .= " LIMIT $start, $length";
	
		// Execute the final query
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$userData = array();
	
		while ($user = mysqli_fetch_assoc($result)) {
			$status = ($user['status'] == 1)
				? '<span class="label label-success">Enabled</span>'
				: '<span class="label label-danger">Disabled</span>';
	
			$userData[] = array(
				$user['id'],
				$user['name'],
				$user['email'],
				$user['create_date'],
				$user['user_type'],
				$status,
				'<button type="button" name="update" id="' . $user["id"] . '" class="btn btn-warning btn-xs update">Edit</button>',
				'<button type="button" name="delete" id="' . $user["id"] . '" class="btn btn-danger btn-xs delete">Delete</button>'
			);
		}
	
		// Prepare the JSON response for DataTables
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $filteredRecords,
			"data" => $userData
		);
	
		echo json_encode($output);
	}
	
	
	public function getUserDetails(){		
		if($this->id) {		
			$sqlQuery = "
				SELECT * 
				FROM ".$this->userTable." 
				WHERE id = '".$this->id."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			echo json_encode($row);
		}		
	}

	public function getInformation($id) {
		$sqlQuery = "SELECT * FROM ".$this->userTable." WHERE id = '".$id."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$userDetails = mysqli_fetch_assoc($result);
		return $userDetails;
	}
	
	public function insert() {      
		if($this->userName && $this->email) {		              
			$this->userName = strip_tags($this->userName);			
			$this->newPassword = md5($this->newPassword);			
			$queryInsert = "
				INSERT INTO ".$this->userTable."(name, email, user_type, status, password) VALUES(
				'".$this->userName."', '".$this->email."', '".$this->role."','".$this->status."', '".$this->newPassword."')";				
			mysqli_query($this->dbConnect, $queryInsert);			
		}
	}	
	
	public function update() {      
		if($this->updateUserId && $this->userName) {		              
			$this->userName = strip_tags($this->userName);

			$changePassword = '';
			if($this->newPassword) {
				$this->newPassword = md5($this->newPassword);
				$changePassword = ", password = '".$this->newPassword."'";
			}
			
			$queryUpdate = "
				UPDATE ".$this->userTable." 
				SET name = '".$this->userName."', email = '".$this->email."', user_type = '".$this->role."', status = '".$this->status."' $changePassword
				WHERE id = '".$this->updateUserId."'";				
			mysqli_query($this->dbConnect, $queryUpdate);			
		}
	}	
	
	public function delete() {      
		if($this->deleteUserId) {		          
			$queryUpdate = "
				UPDATE ".$this->userTable." SET status=0
				WHERE id = '".$this->deleteUserId."'";				
			mysqli_query($this->dbConnect, $queryUpdate);			
		}
	}
	
}