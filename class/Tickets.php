<?php

class Tickets extends Database {  
    private $ticketTable = 'hd_tickets';
	private $ticketRepliesTable = 'hd_ticket_replies';
	private $departmentsTable = 'hd_departments';
	private $subjectsTable = 'hd_subjects';
	private $dbConnect = false;
	public function __construct(){		
        $this->dbConnect = $this->dbConnect();
    } 
	
	public function showTickets(){

		$start = $_POST['start'] ?? 0;  // Start index for pagination
		$length = $_POST['length'] ?? 10;  // Number of records per page
		$sqlWhere = '';	

		$totalQuery = "SELECT COUNT(*) AS total FROM " . $this->ticketTable;
		$totalResult = mysqli_query($this->dbConnect, $totalQuery);
		$totalRecords = mysqli_fetch_assoc($totalResult)['total'];

		if(!isset($_SESSION["admin"])) {
			$sqlWhere .= " WHERE t.user = '".$_SESSION["userid"]."' ";
			if(!empty($_POST["search"]["value"])){
				$sqlWhere .= " and ";
			}
		} else if(isset($_SESSION["admin"]) && !empty($_POST["search"]["value"])) {
			$sqlWhere .= " WHERE ";
		} 		
		$time = new time;

		$sqlQuery = "SELECT t.id, t.uniqid, s.name as title, t.createdfor as cfor, t.init_msg as tmessage, t.date, t.last_reply, t.resolved, u.name as creater, d.name as department, u.user_type, t.user, t.user_read, t.admin_read
			FROM hd_tickets t 
			LEFT JOIN hd_users u ON t.user = u.id 
			LEFT JOIN hd_subjects s ON t.title = s.id  
			LEFT JOIN hd_departments d ON t.department = d.id $sqlWhere ";



		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' (uniqid LIKE "%'.$_POST["search"]["value"].'%" ';					
			$sqlQuery .= ' OR s.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR t.createdfor LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR d.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR resolved LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR last_reply LIKE "%'.$_POST["search"]["value"].'%") ';			
		}

		$filteredResult = mysqli_query($this->dbConnect, $sqlQuery);
		$filteredRecords = mysqli_num_rows($filteredResult);

		if(!empty($_POST["order"])){
			
			$orderColumnIndex = $_POST['order']['0']['column'];
			$orderColumnName = $_POST['columns'][$orderColumnIndex]['data'];

			if ($orderColumnName == '0' || $orderColumnName == 't.id') {
				$sqlQuery .= ' ORDER BY t.id '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '1' || $orderColumnName == 't.uniqid') {
				$sqlQuery .= ' ORDER BY t.uniqid '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '2' || $orderColumnName == 'title') {
				$sqlQuery .= ' ORDER BY s.name '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '3' || $orderColumnName == 'department') {
				$sqlQuery .= ' ORDER BY d.name '.$_POST['order']['0']['dir'].' ';
			} 
			elseif ($orderColumnName == '4' || $orderColumnName == 'cfor') {
				$sqlQuery .= ' ORDER BY t.createdfor '.$_POST['order']['0']['dir'].' ';
			}
			elseif ($orderColumnName == '5' || $orderColumnName == 'creater') {
				$sqlQuery .= ' ORDER BY u.name '.$_POST['order']['0']['dir'].' ';
			}
			elseif ($orderColumnName == '6' || $orderColumnName == 't.date') {
				$sqlQuery .= ' ORDER BY t.date '.$_POST['order']['0']['dir'].' ';
			}
			elseif ($orderColumnName == '7' || $orderColumnName == 't.resolved') {
				$sqlQuery .= ' ORDER BY t.resolved '.$_POST['order']['0']['dir'].' ';
			}

		} else {
			$sqlQuery .= 'ORDER BY t.id DESC ';
		}
		
		// Add LIMIT clause for pagination
		$sqlQuery .= " LIMIT $start, $length";

		function formatDateOrDaysAgo($dateString) {
			// Convert the string date to a timestamp
			$timestampInt = (int)$dateString;
			$timestampString = $dateString;
			$now = time();
		
			// date('Y-m-d', (int)$ticket['date']);
			// Calculate the difference in seconds
			$diff = $now - $timestampString;
		
			// Convert to days
			$days = floor($diff / (60 * 60 * 24));
		
			// If more than 7 days ago, show the actual date
			if ($days > 7) {
				return date('m-d-Y', $timestampInt); // Adjust the date format as needed
			} else {
				return $days . ' days ago';
			}
		}

		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$ticketData = array();	

		while ($ticket = mysqli_fetch_assoc($result)) {
			$status = ($ticket['resolved'] == 0)
				? '<span class="label label-success">Open</span>'
				: '<span class="label label-danger">Closed</span>';
			$title = $ticket['title'];
			if((isset($_SESSION["admin"]) && !$ticket['admin_read'] && $ticket['last_reply'] != $_SESSION["userid"]) || (!isset($_SESSION["admin"]) && !$ticket['user_read'] && $ticket['last_reply'] != $ticket['user'])) {
				$title = $this->getRepliedTitle($ticket['title']);			
			}
			$disbaled = '';
			if(!isset($_SESSION["admin"])) {
				$disbaled = 'disabled';
			}

			$ticketData[] = array(
				$ticket['id'],
				$ticket['uniqid'],
				$title,
				$ticket['department'],
				$ticket['cfor'],
				$ticket['creater'],
				formatDateOrDaysAgo($ticket['date']),
				$status,
				'<a href="view_ticket.php?id='.$ticket["uniqid"].'" class="btn btn-success btn-xs update">View Ticket</a>',
				'<button type="button" name="update" id="' . $ticket["id"] . '" class="btn btn-warning btn-xs update">Edit</button>',
				'<button type="button" name="delete" id="' . $ticket["id"] . '" class="btn btn-danger btn-xs delete">Close</button>'
			);
		}
		// Prepare the JSON response for DataTables
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal" 		=>  $totalRecords,
			"recordsFiltered" 	=>  $filteredRecords,
			"data"    			=> 	$ticketData
		);
		echo json_encode($output);
	}	
	
	public function getRepliedTitle($title) {
		$title = $title.'<span class="answered">Answered</span>';
		return $title; 		
	}

	public function createTicket() {      
		if(!empty($_POST['subjectName']) && !empty($_POST['message'])) {                
			$date = new DateTime();
			$date = $date->getTimestamp();
			$uniqid = uniqid();                
			$message = strip_tags($_POST['message']);              
			$queryInsert = "INSERT INTO ".$this->ticketTable." (uniqid, user, createdfor, title, init_msg, department, date, last_reply, user_read, admin_read, resolved) 
			VALUES('".$uniqid."', '".$_SESSION["userid"]."', '".$_POST['name']."', '".$_POST['subjectName']."', '".$message."', '".$_POST['departmentName']."', '".$date."', '".$_SESSION["userid"]."', 0, 0, '".$_POST['status']."')";			
			mysqli_query($this->dbConnect, $queryInsert);			
			echo 'success ' . $uniqid;
		} else {
			echo '<div class="alert error">Please fill in all fields.</div>';
		}
	}	
	public function getTicketDetails(){
		if($_POST['ticketId']) {	
			$sqlQuery = "
				SELECT * FROM ".$this->ticketTable." 
				WHERE id = '".$_POST["ticketId"]."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			echo json_encode($row);
		}
	}
	public function updateTicket() {
		if($_POST['ticketId']) {	
			$updateQuery = "UPDATE ".$this->ticketTable." 
			SET createdfor = '".$_POST['name']."', title = '".$_POST["subjectName"]."', department = '".$_POST["departmentName"]."', init_msg = '".$_POST["message"]."', resolved = '".$_POST["status"]."'
			WHERE id ='".$_POST["ticketId"]."'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
		}	
	}		
	public function closeTicket(){
		if($_POST["ticketId"]) {
			$sqlDelete = "UPDATE ".$this->ticketTable." 
				SET resolved = '1'
				WHERE id = '".$_POST["ticketId"]."'";		
			mysqli_query($this->dbConnect, $sqlDelete);		
		}
	}	
	public function getDepartments() {       
		$sqlQuery = "SELECT * FROM ".$this->departmentsTable." 
					WHERE status=1";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		while($department = mysqli_fetch_assoc($result) ) {       
            echo '<option value="' . $department['id'] . '">' . $department['name']  . '</option>';           
        }
    }	    
	// Subjects Category
	public function getSubjects() {       
		$sqlQuery = "SELECT * FROM ".$this->subjectsTable."
					WHERE status=1";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		while($subject = mysqli_fetch_assoc($result) ) {       
            echo '<option value="' . $subject['id'] . '">' . $subject['name']  . '</option>';           
        }
    }	
    public function ticketInfo($id) {  		
		$sqlQuery = "SELECT t.id, t.uniqid, t.title, t.user as tUser, t.createdFor as cfor, t.init_msg as tmessage, t.date, t.last_reply, t.resolved, u.name as creater, u.user_type as userType, d.name as department 
			FROM ".$this->ticketTable." t 
			LEFT JOIN hd_users u ON t.user = u.id 
			LEFT JOIN hd_subjects s ON t.title = s.id 
			LEFT JOIN hd_departments d ON t.department = d.id 
			WHERE t.uniqid = '".$id."'";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
        $tickets = mysqli_fetch_assoc($result);
        return $tickets;        
    }    
	public function saveTicketReplies () {
		if($_POST['message']) {
			$date = new DateTime();
			$date = $date->getTimestamp();
			$queryInsert = "INSERT INTO ".$this->ticketRepliesTable." (user, text, ticket_id, date) 
				VALUES('".$_SESSION["userid"]."', '".$_POST['message']."', '".$_POST['ticketId']."', '".$date."')";
			mysqli_query($this->dbConnect, $queryInsert);				
			$updateTicket = "UPDATE ".$this->ticketTable." 
				SET last_reply = '".$_SESSION["userid"]."', user_read = '0', admin_read = '0' 
				WHERE id = '".$_POST['ticketId']."'";				
			mysqli_query($this->dbConnect, $updateTicket);
		} 
	}	
	public function getTicketReplies($id) {  		
		$sqlQuery = "SELECT r.id, r.text as message, r.date, u.name as creater, d.name as department, u.user_type  
			FROM ".$this->ticketRepliesTable." r
			LEFT JOIN ".$this->ticketTable." t ON r.ticket_id = t.id
			LEFT JOIN hd_users u ON r.user = u.id 
			LEFT JOIN hd_subjects s ON t.title = s.id 
			LEFT JOIN hd_departments d ON t.department = d.id 
			WHERE r.ticket_id = '".$id."'";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
       	$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
        return $data;
    }
	public function updateTicketReadStatus($ticketId) {
		$updateField = '';
		if(isset($_SESSION["admin"])) {
			$updateField = "admin_read = '1'";
		} else {
			$updateField = "user_read = '1'";
		}
		$updateTicket = "UPDATE ".$this->ticketTable." 
			SET $updateField
			WHERE id = '".$ticketId."'";				
		mysqli_query($this->dbConnect, $updateTicket);
	}
}