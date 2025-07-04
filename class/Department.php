<?php

class Department extends Database {  
    
	private $departmentsTable = 'hd_departments';
	
	private $dbConnect = false;
	public function __construct(){		
        $this->dbConnect = $this->dbConnect();
    } 
	// public function listDepartment1(){
			 			 
	// 	$sqlQuery = "SELECT id, name, status
	// 		FROM ".$this->departmentsTable;
			
	// 	if(!empty($_POST["search"]["value"])){
	// 		$sqlQuery .= ' (id LIKE "%'.$_POST["search"]["value"].'%" ';					
	// 		$sqlQuery .= ' OR name LIKE "%'.$_POST["search"]["value"].'%" ';
	// 		$sqlQuery .= ' OR status LIKE "%'.$_POST["search"]["value"].'%" ';					
	// 	}
	// 	if(!empty($_POST["order"])){

	// 		$orderColumnIndex = $_POST['order']['0']['column'];
	// 		$orderColumnName = $_POST['columns'][$orderColumnIndex]['data'];

	// 		if ($orderColumnName == '1' || $orderColumnName == 'name') {
	// 			$sqlQuery .= ' ORDER BY name '.$_POST['order']['0']['dir'].' ';
	// 		} 
	// 		elseif ($orderColumnName == '2' || $orderColumnName == 'status') {
	// 			$sqlQuery .= ' ORDER BY status '.$_POST['order']['0']['dir'].' ';
	// 		} 

	// 	} else {
	// 		$sqlQuery .= ' ORDER BY status DESC ';
	// 	}
	// 	if($_POST["length"] != -1){
	// 		$sqlQuery .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	// 	}	
		
	// 	$result = mysqli_query($this->dbConnect, $sqlQuery);
	// 	$numRows = mysqli_num_rows($result);
	// 	$departmentData = array();	
	// 	while( $department = mysqli_fetch_assoc($result) ) {		
	// 		$departmentRows = array();			
	// 		$status = '';
	// 		if($department['status'] == 1)	{
	// 			$status = '<span class="label label-success">Enabled</span>';
	// 		} else if($department['status'] == 0) {
	// 			$status = '<span class="label label-danger">Disabled</span>';
	// 		}	
			
	// 		$departmentRows[] = $department['id'];
	// 		$departmentRows[] = $department['name'];			
	// 		$departmentRows[] = $status;
				
	// 		$departmentRows[] = '<button type="button" name="update" id="'.$department["id"].'" class="btn btn-warning btn-xs update">Edit</button>';
	// 		$departmentRows[] = '<button type="button" name="delete" id="'.$department["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
	// 		$departmentData[] = $departmentRows;
	// 	}
	// 	$output = array(
	// 		"draw"				=>	intval($_POST["draw"]),
	// 		"recordsTotal"  	=>  $numRows,
	// 		"recordsFiltered" 	=> 	$numRows,
	// 		"data"    			=> 	$departmentData
	// 	);
	// 	echo json_encode($output);
	// }	


	public function listDepartment() {
		$start = $_POST['start'] ?? 0;  // Start index for pagination
		$length = $_POST['length'] ?? 10;  // Number of records per page
	
		// Query to get total number of records without filters
		$totalQuery = "SELECT COUNT(*) AS total FROM " . $this->departmentsTable;
		$totalResult = mysqli_query($this->dbConnect, $totalQuery);
		$totalRecords = mysqli_fetch_assoc($totalResult)['total'];
	
		// Build the main query with search filter if applicable
		$sqlQuery = "SELECT id, name, status FROM " . $this->departmentsTable;
	
		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' WHERE id LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR name LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR status LIKE "%' . $_POST["search"]["value"] . '%" ';
		}
	
		// Execute the filtered query to get the number of filtered records
		$filteredResult = mysqli_query($this->dbConnect, $sqlQuery);
		$filteredRecords = mysqli_num_rows($filteredResult);
	
		// Add ORDER BY clause for sorting
		if(!empty($_POST["order"])){

			$orderColumnIndex = $_POST['order']['0']['column'];
			$orderColumnName = $_POST['columns'][$orderColumnIndex]['data'];

			if ($orderColumnName == '0' || $orderColumnName == 'name') {
				$sqlQuery .= ' ORDER BY name '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '1' || $orderColumnName == 'status') {
				$sqlQuery .= ' ORDER BY status '.$_POST['order']['0']['dir'].' ';
			} 

		} else {
			$sqlQuery .= ' ORDER BY status DESC ';
		}
	
		// Add LIMIT clause for pagination
		$sqlQuery .= " LIMIT $start, $length";
	
		// Execute the final query
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$departmentData = array();
	
		while ($department = mysqli_fetch_assoc($result)) {
			$status = ($department['status'] == 1)
				? '<span class="label label-success">Enabled</span>'
				: '<span class="label label-danger">Disabled</span>';
	
			$departmentData[] = array(
				$department['name'],
				$status,
				'<button type="button" name="update" id="' . $department["id"] . '" class="btn btn-warning btn-xs update">Edit</button>',
				'<button type="button" name="delete" id="' . $department["id"] . '" class="btn btn-danger btn-xs delete">Delete</button>'
			);
		}
	
		// Prepare the JSON response for DataTables
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $filteredRecords,
			"data" => $departmentData
		);
	
		echo json_encode($output);
	}
	
		
	public function getDepartmentDetails(){		
		if($this->departmentId) {		
			$sqlQuery = "
				SELECT id, name, status 
				FROM ".$this->departmentsTable." 
				WHERE id = '".$this->departmentId."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			echo json_encode($row);
			return $row;
		}		
		// return NULL;
	}
	
	public function insert() {      
		if($this->department) {		              
			$this->department = strip_tags($this->department);              
			$queryInsert = "INSERT INTO ".$this->departmentsTable." (name, status) 
			VALUES('".$this->department."', '".$this->status."')";			
			mysqli_query($this->dbConnect, $queryInsert);			
		}
	}

	public function update() {      
		if($this->departmentId && $this->department) {		              
			$this->department = strip_tags($this->department);              
			$queryUpdate = "
				UPDATE ".$this->departmentsTable." 
				SET name = '".$this->department."', status = '".$this->status."' 
				WHERE id = '".$this->departmentId."'";				
			mysqli_query($this->dbConnect, $queryUpdate);			
		}
	}	
	
	public function delete() {      
		if($this->departmentId) {		          
			$queryUpdate = "
				UPDATE ".$this->departmentsTable." SET status = 0 
				WHERE id = '".$this->departmentId."'";				
			mysqli_query($this->dbConnect, $queryUpdate);			
		}
	}
	
}