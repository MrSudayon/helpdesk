<?php

class Purchase extends Database {
	private $usersTable = 'hd_users'; 
	private $departmentsTable = 'hd_departments';
    private $ticketTable = 'hd_tickets';
	private $ticketRepliesTable = 'hd_ticket_replies';
    private $categoryTable = 'hd_category';
	private $purchaseTable = 'hd_purchase_requests';
	private $dbConnect = false;
	public function __construct(){		
        $this->dbConnect = $this->dbConnect();
    } 
      
	
	public function createPurchaseReqForm($data) {
		
		$date = new DateTime();
		$date = $date->getTimestamp();
		$uniqid = uniqid();                
		$subject = strip_tags($_POST['subject']);          
		$company = $data['company'];
		$department = $data['department'];
		$endorsedby = $data['endorsedby'];
		$payment = $data['payment'];
		$payee = $data['cheqpayee'];
		$dateneeded = $data['dateneeded'];
		$amount = $data['amount'];

		$queryInsert = 
			"INSERT INTO " .$this->purchaseTable. "(uniqId, company, requestedby, department, endorsedby, date, subject, payment, payee, dateneeded, amount, status) 
				VALUES ('".$uniqid."', '$company','".$_SESSION["userid"]."','$department','$endorsedby','$date','$subject','$payment','$payee','$dateneeded','$amount',1)";			
		
		mysqli_query($this->dbConnect, $queryInsert);
		echo 'success ' . $uniqid;
		if ($this->dbConnect->query($queryInsert) === TRUE) {
			// echo "Purchase requested form created successfully";
			return true;
		} else {
			// echo "Error: " . $queryInsert . "<br>" . $this->dbConnect->error;
			return false;
		}
	}	
	// public function getTicketDetails(){
	// 	if($_POST['ticketId']) {	
	// 		$sqlQuery = "
	// 			SELECT * FROM ".$this->ticketTable." 
	// 			WHERE id = '".$_POST["ticketId"]."'";
	// 		$result = mysqli_query($this->dbConnect, $sqlQuery);	
	// 		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	// 		echo json_encode($row);
	// 	}
	// }
	// public function updateTicket() {
	// 	if($_POST['ticketId']) {	
	// 		$updateQuery = "UPDATE ".$this->ticketTable." 
	// 		SET title = '".$_POST["subject"]."', department = '".$_POST["department"]."', init_msg = '".$_POST["message"]."', resolved = '".$_POST["status"]."'
	// 		WHERE id ='".$_POST["ticketId"]."'";
	// 		$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
	// 	}	
	// }		
	// public function closeTicket(){
	// 	if($_POST["ticketId"]) {
	// 		$sqlDelete = "UPDATE ".$this->ticketTable." 
	// 			SET resolved = '1'
	// 			WHERE id = '".$_POST["ticketId"]."'";		
	// 		mysqli_query($this->dbConnect, $sqlDelete);		
	// 	}
	// }	
	public function getDepartments() {       
		$sqlQuery = "SELECT * FROM ".$this->departmentsTable;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		while($department = mysqli_fetch_assoc($result) ) {       
            echo '<option value="' . $department['id'] . '">' . $department['name']  . '</option>';           
        }
    }	
	public function getCompany() {       
		// $sqlQuery = "SELECT * FROM ".$this->departmentsTable;
		// $result = mysqli_query($this->dbConnect, $sqlQuery);
		// while($department = mysqli_fetch_assoc($result) ) {       
        //     echo '<option value="' . $department['id'] . '">' . $department['name']  . '</option>';           
        // }
			echo '<option value="Oxychem Corp.">Oxychem Corporation</option>';           
            echo '<option value="Sauber">Sauber</option>';           
    }	  
	
	public function getAdminUsers() {
		$sqlQuery = "SELECT * FROM ".$this->usersTable." WHERE user_type != 'user' ";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
        while($user = mysqli_fetch_assoc($result) ) {       
            echo '<option value="' . $user['id'] . '">' . $user['name']  . '</option>';           
        }
	}
    // public function ticketInfo($id) {  		
	// 	$sqlQuery = "SELECT t.id, t.uniqid, t.title, t.user, t.init_msg as message, t.date, t.last_reply, t.resolved, u.name as creater, d.name as department 
	// 		FROM ".$this->ticketTable." t 
	// 		LEFT JOIN hd_users u ON t.user = u.id 
	// 		LEFT JOIN hd_departments d ON t.department = d.id 
	// 		WHERE t.uniqid = '".$id."'";	
	// 	$result = mysqli_query($this->dbConnect, $sqlQuery);
    //     $tickets = mysqli_fetch_assoc($result);
    //     return $tickets;        
    // }    
	// public function saveTicketReplies () {
	// 	if($_POST['message']) {
	// 		$date = new DateTime();
	// 		$date = $date->getTimestamp();
	// 		$queryInsert = "INSERT INTO ".$this->ticketRepliesTable." (user, text, ticket_id, date) 
	// 			VALUES('".$_SESSION["userid"]."', '".$_POST['message']."', '".$_POST['ticketId']."', '".$date."')";
	// 		mysqli_query($this->dbConnect, $queryInsert);				
	// 		$updateTicket = "UPDATE ".$this->ticketTable." 
	// 			SET last_reply = '".$_SESSION["userid"]."', user_read = '0', admin_read = '0' 
	// 			WHERE id = '".$_POST['ticketId']."'";				
	// 		mysqli_query($this->dbConnect, $updateTicket);
	// 	} 
	// }	
	// public function getTicketReplies($id) {  		
	// 	$sqlQuery = "SELECT r.id, r.text as message, r.date, u.name as creater, d.name as department, u.user_type  
	// 		FROM ".$this->ticketRepliesTable." r
	// 		LEFT JOIN ".$this->ticketTable." t ON r.ticket_id = t.id
	// 		LEFT JOIN hd_users u ON r.user = u.id 
	// 		LEFT JOIN hd_departments d ON t.department = d.id 
	// 		WHERE r.ticket_id = '".$id."'";	
	// 	$result = mysqli_query($this->dbConnect, $sqlQuery);
    //    	$data= array();
	// 	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	// 		$data[]=$row;            
	// 	}
    //     return $data;
    // }
	// public function updateTicketReadStatus($ticketId) {
	// 	$updateField = '';
	// 	if(isset($_SESSION["admin"])) {
	// 		$updateField = "admin_read = '1'";
	// 	} else {
	// 		$updateField = "user_read = '1'";
	// 	}
	// 	$updateTicket = "UPDATE ".$this->ticketTable." 
	// 		SET $updateField
	// 		WHERE id = '".$ticketId."'";				
	// 	mysqli_query($this->dbConnect, $updateTicket);
	// }
}