<?php

class Subject extends Database {  
    
	private $subjectsTable = 'hd_subjects';
	
	private $dbConnect = false;
	public function __construct(){		
        $this->dbConnect = $this->dbConnect();
    } 
	
	public function listSubject(){
			 			 
		$sqlQuery = "SELECT id, name, status
			FROM ".$this->subjectsTable;
			
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' (id LIKE "%'.$_POST["search"]["value"].'%" ';					
			$sqlQuery .= ' OR name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR status LIKE "%'.$_POST["search"]["value"].'%" ';					
		}
		if(!empty($_POST["order"])){

			$orderColumnIndex = $_POST['order']['0']['column'];
			$orderColumnName = $_POST['columns'][$orderColumnIndex]['data'];

			if ($orderColumnName == '1' || $orderColumnName == 'name') {
				$sqlQuery .= ' ORDER BY name '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '2' || $orderColumnName == 'status') {
				$sqlQuery .= ' ORDER BY status '.$_POST['order']['0']['dir'].' ';
			} 

		} else {
			$sqlQuery .= ' ORDER BY status DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$subjectData = array();	
		while( $subject = mysqli_fetch_assoc($result) ) {		
			$subjectRows = array();			
			$status = '';
			if($subject['status'] == 1)	{
				$status = '<span class="label label-success">Enabled</span>';
			} else if($subject['status'] == 0) {
				$status = '<span class="label label-danger">Disabled</span>';
			}	
			
			$subjectRows[] = $subject['id'];
			$subjectRows[] = $subject['name'];		
			$subjectRows[] = $status;
				
			$subjectRows[] = '<button type="button" name="update" id="'.$subject["id"].'" class="btn btn-warning btn-xs update">Edit</button>';
			$subjectRows[] = '<button type="button" name="delete" id="'.$subject["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
			$subjectData[] = $subjectRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$subjectData
		);
		echo json_encode($output);
	}	
		
	public function getSubjectDetails(){		
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