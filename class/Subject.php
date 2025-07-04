<?php

class Subject extends Database {
    
	private $subjectsTable = 'hd_subjects';
	
	private $dbConnect = false;
	public function __construct(){
        $this->dbConnect = $this->dbConnect();
    }
	
	public function listSubject() {
		$start = $_POST['start'] ?? 0;  // Start index for pagination
		$length = $_POST['length'] ?? 10;  // Number of records per page
	
		// Query to get total number of records without filters
		$totalQuery = "SELECT COUNT(*) AS total FROM " . $this->subjectsTable;
		$totalResult = mysqli_query($this->dbConnect, $totalQuery);
		$totalRecords = mysqli_fetch_assoc($totalResult)['total'];
	
		// Build the main query with search filter if applicable
		$sqlQuery = "SELECT id, name, status FROM " . $this->subjectsTable;
	
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
		$subjectData = array();
	
		while ($subject = mysqli_fetch_assoc($result)) {
			$status = ($subject['status'] == 1)
				? '<span class="label label-success">Enabled</span>'
				: '<span class="label label-danger">Disabled</span>';
	
			$subjectData[] = array(
				$subject['name'],
				$status,
				'<button type="button" name="update" id="' . $subject["id"] . '" class="btn btn-warning btn-xs update">Edit</button>',
				'<button type="button" name="delete" id="' . $subject["id"] . '" class="btn btn-danger btn-xs delete">Delete</button>'
			);
		}
	
		// Prepare the JSON response for DataTables
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $filteredRecords,
			"data" => $subjectData
		);
	
		echo json_encode($output);
	}

	public function getSubjectDetail($id) {
		$sqlQuery = "
				SELECT id, name, status 
				FROM ".$this->subjectsTable." 
				WHERE id = '".$id."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}
		
	public function getSubjectDetails() {
		if($this->subjectId) {
			$sqlQuery = "
				SELECT id, name, status 
				FROM ".$this->subjectsTable." 
				WHERE id = '".$this->subjectId."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			echo json_encode($row);
		}		
	}
	
	public function insert() {
		if($this->subject) {		              
			$this->subject = strip_tags($this->subject);              
			$queryInsert = "INSERT INTO ".$this->subjectsTable." (name, status) 
			VALUES('".$this->subject."', '".$this->status."')";			
			mysqli_query($this->dbConnect, $queryInsert);			
		}
	}

	public function update() {
		if($this->subjectId && $this->subject) {
			$this->subject = strip_tags($this->subject);              
			$queryUpdate = "
				UPDATE ".$this->subjectsTable." 
				SET name = '".$this->subject."', status = '".$this->status."' 
				WHERE id = '".$this->subjectId."'";				
			mysqli_query($this->dbConnect, $queryUpdate);			
		}
	}	
	
	public function delete() {
		if($this->subjectId) {
			$queryUpdate = "
				UPDATE ".$this->subjectsTable." SET status = 0 
				WHERE id = '".$this->subjectId."'";				
			mysqli_query($this->dbConnect, $queryUpdate);			
		}
	}
	
}