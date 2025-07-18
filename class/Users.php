<?php
class Users extends Database { 
	private $userTable = 'hd_users';
	private $departmentTable = 'hd_departments';
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
		if(!empty($_POST["login"]) && $_POST["email"]!='' && $_POST["password"]!='') {	
			$email = $_POST['email'];
			$password = $_POST['password'];
			$sqlQuery = "SELECT * FROM ".$this->userTable." 
				WHERE email='".$email."' AND password='".md5($password)."' AND status = 1";
				
			$resultSet = mysqli_query($this->dbConnect, $sqlQuery);
			$isValidLogin = mysqli_num_rows($resultSet);	
			if($isValidLogin){
				$userDetails = mysqli_fetch_assoc($resultSet);
				$_SESSION['LAST_ACTIVITY'] = time();
				$_SESSION["userid"] = $userDetails['id'];
				$_SESSION["user_name"] = $userDetails['name'];
				$_SESSION["userDepartment"] = $userDetails['department'];
				$_SESSION["user_type"] = $userDetails['user_type'];
				if($userDetails['user_type'] == 'admin') {
					$_SESSION["admin"] = 1;
				}
				header("location: introduction.php"); 		
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
		if(!empty($_SESSION["userid"]) && ($_SESSION['userDepartment'] != 0)) {
			$sqlQuery = "SELECT u.id, d.id as dId, d.name as dName, u.name as uName, email, u.department, create_date, user_type, u.status, d.status 
				-- FROM ".$this->userTable." u 
				-- LEFT JOIN ".$this->departmentTable." d ON u.department = d.id 
				FROM ".$this->userTable." u 
				LEFT JOIN ".$this->departmentTable." d ON u.department = d.id 
				WHERE u.id ='".$_SESSION["userid"]."' AND d.status = '1'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);		
			$userDetails = mysqli_fetch_assoc($result);
			return $userDetails;
		} else {
			$sqlQuery = "SELECT id,name as uName, email, department, create_date, user_type, status 
				FROM ".$this->userTable." 
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

	public function listUser() {
		$start = $_POST['start'] ?? 0;  // Start index for pagination
		$length = $_POST['length'] ?? 10;  // Number of records per page
		$sqlWhere = '';	
	
		// Query to get total number of records without filters
		$totalQuery = "SELECT COUNT(*) AS total FROM " . $this->userTable;
		$totalResult = mysqli_query($this->dbConnect, $totalQuery);
		$totalRecords = mysqli_fetch_assoc($totalResult)['total'];

		if(!isset($_SESSION["admin"])) {
			$sqlWhere .= " WHERE u.id = '".$_SESSION["userid"]."' ";
			if(!empty($_POST["search"]["value"])){
				$sqlWhere .= " and ";
			}
		}
	
		// Build the main query with search filter if applicable
		$sqlQuery = "SELECT u.id as uId, u.email as uEmail, create_date, u.name as uName, u.department, user_type, u.status, d.id, d.name as deptName 
				FROM hd_users u
				LEFT JOIN hd_departments d ON u.department = d.id ";
	
		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= 'WHERE (u.email LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR u.id LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR u.name LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR d.name LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR user_type LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR u.status LIKE "%' . $_POST["search"]["value"] . '%" )';
		}
	
		// Execute the filtered query to get the number of filtered records
		$filteredResult = mysqli_query($this->dbConnect, $sqlQuery);
		$filteredRecords = mysqli_num_rows($filteredResult);
	
		// Add ORDER BY clause for sorting
		if(!empty($_POST["order"])){

			$orderColumnIndex = $_POST['order']['0']['column'];
			$orderColumnName = $_POST['columns'][$orderColumnIndex]['data'];

			if ($orderColumnName == '1' || $orderColumnName == 'name') {
				$sqlQuery .= ' ORDER BY u.name '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '2' || $orderColumnName == 'email') {
				$sqlQuery .= ' ORDER BY email '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '3' || $orderColumnName == 'department') {
				$sqlQuery .= ' ORDER BY department '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '4' || $orderColumnName == 'create_date') {
				$sqlQuery .= ' ORDER BY create_date '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '5' || $orderColumnName == 'user_type') {
				$sqlQuery .= ' ORDER BY user_type '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '6' || $orderColumnName == 'status') {
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
				$user['uId'],
				$user['uName'],
				$user['uEmail'],
				$user['deptName'],
				$user['create_date'],
				$user['user_type'],
				$status,
				'<button type="button" name="update" id="' . $user["uId"] . '" class="btn btn-warning btn-xs update">Edit</button>',
				'<button type="button" name="delete" id="' . $user["uId"] . '" class="btn btn-danger btn-xs delete">Delete</button>'
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
				INSERT INTO ".$this->userTable."(name, email, department, user_type, status, password) VALUES(
				'".$this->userName."', '".$this->email."', '".$this->department."','".$this->role."','".$this->status."', '".$this->newPassword."')";				
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
				SET name = '".$this->userName."', email = '".$this->email."', department = '".$this->department."', user_type = '".$this->role."', status = '".$this->status."' $changePassword
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
