<?php
class Tickets extends Database {  
    private $ticketTable = 'hd_tickets';
	private $ticketRepliesTable = 'hd_ticket_replies';
	private $departmentsTable = 'hd_departments';
	private $subjectsTable = 'hd_subjects';
	private $usersTable = 'hd_users';
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
		

		$sqlQuery = "SELECT t.id, t.uniqid, s.name as title, t.createdfor as cfor, t.init_msg as tmessage, t.date, t.dateresolved, t.last_reply, t.resolved, u.name as creater, d.name as department, u.user_type, t.user, t.user_read, t.admin_read
			FROM hd_tickets t 
			LEFT JOIN hd_users u ON t.user = u.id 
			LEFT JOIN hd_subjects s ON t.title = s.id  
			LEFT JOIN hd_departments d ON t.department = d.id $sqlWhere ";



		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= ' (uniqid LIKE "%'.$_POST["search"]["value"].'%" ';					
			$sqlQuery .= ' OR s.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR t.createdfor LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR d.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR u.name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR resolved LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR last_reply LIKE "%'.$_POST["search"]["value"].'%" ';		
			$sqlQuery .= ' OR t.date LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= ' OR t.dateresolved LIKE "%'.$_POST["search"]["value"].'%") ';			
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
			elseif ($orderColumnName == '8' || $orderColumnName == 't.dateresolved') {
				$sqlQuery .= ' ORDER BY t.dateresolved '.$_POST['order']['0']['dir'].' ';
			}
			
			

		} else {
			$sqlQuery .= 'ORDER BY t.resolved ASC, t.date DESC';
		}
		
		$sqlQuery .= " LIMIT $start, $length";


		function formatDateOrDaysAgo($dateString) {
			// Check if the dateString is the placeholder "On Progress"
			if ($dateString === 'On Progress') {
				return 'On Progress';
			}
		
			// Convert the date string to an integer timestamp
			$timestampInt = (int)$dateString;
			
			// Initialize a DateTime object in the GMT+8 timezone
			$timestampDate = (new DateTime())->setTimestamp($timestampInt)->setTimezone(new DateTimeZone('GMT+8')); // Adjust to GMT+8

			// Calculate the difference in seconds from the current time
			$now = new DateTime("now", new DateTimeZone('GMT+8'));
			$diffInSeconds = $now->getTimestamp() - $timestampInt;
		
			// Convert the difference to days
			$days = floor($diffInSeconds / (60 * 60 * 24));
			
			// If the timestamp is within today, display time only
			if ($days < 1) {
				return $timestampDate->format('M-d') . ' at ' . $timestampDate->format('h:i A');
				
			} 
			// If the timestamp is within 7 days, show how many days ago
			elseif ($days <= 7) {
				return $days . ' day/s ago';
			} 
			// Otherwise, return the full date and time
			else {
				// return $timestampDate->format('m-d-Y H:i:s');
				return $timestampDate->format('m-d-Y');
			}
		}

		function duration($start, $end) {
		
			if($end != 'On Progress') {
				// Convert timestamps to DateTime objects with timezone
				try {
					$timestampStart = (new DateTime())->setTimestamp((int)$start)->setTimezone(new DateTimeZone('GMT+8'));
					$timestampEnd = (new DateTime())->setTimestamp((int)$end)->setTimezone(new DateTimeZone('GMT+8'));
				} catch (Exception $e) {
					return 'Invalid Timestamps';
				}
				
				// Ensure correct order for past duration
				if ($start > $end) {
					$interval = $timestampEnd->diff($timestampStart); // Swap for correct past duration
					$past = true;
				} else {
					$interval = $timestampStart->diff($timestampEnd);
					$past = false;
				}
				
				// Build format conditionally
				$format = '';
				if ($interval->y > 0) {
					$format .= '%yY ';
				}
				if ($interval->m > 0) {
					$format .= '%mM ';
				}
				if ($interval->d > 0) {
					$format .= '%dD ';
				}
				$format .= '%hH %iM'; // Always include hours and minutes
				
				// Format the output
				$duration = sprintf($interval->format($format));
				
				// Add "ago" if it's in the past
				return $past ? $duration . ' ago' : $duration;
			} else {
				return 'On Progress';
			}
		}


		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$ticketData = array();	

		while ($ticket = mysqli_fetch_assoc($result)) {

			$status = ($ticket['resolved'] == 0)
				? '<span class="label label-success">Open</span>'
				: '<span class="label label-danger">Closed</span>';
			$title = $ticket['title'];

			if((isset($_SESSION["admin"]) && !$ticket['admin_read'] && $ticket['last_reply'] != $_SESSION["userid"]) 
			|| (!isset($_SESSION["admin"]) && !$ticket['user_read'] && $ticket['last_reply'] != $ticket['user'])) {
				$title = $this->getRepliedTitle($ticket['title']);			
			}
			
			$texts = 'ste';
			$disbaled = '';
			if(!isset($_SESSION["admin"])) {
				$disbaled = 'disabled';
				$ticketData[] = array(
					$ticket['id'],
					$ticket['uniqid'],
					$title,
					$ticket['department'],
					$ticket['creater'],
					formatDateOrDaysAgo($ticket['date']),
					$status,
					duration($ticket['date'], $ticket['dateresolved']),
					'<a href="view_ticket.php?id='.$ticket["uniqid"].'" class="btn btn-success btn-xs update">View Ticket</a>',
					'<button type="button" name="update" id="' . $ticket["id"] . '" class="btn btn-warning btn-xs update">Edit</button>',
					'<button type="button" name="delete" id="' . $ticket["id"] . '" class="btn btn-danger btn-xs delete">Close</button>'
				);
			} else {
				$ticketData[] = array(
					$ticket['id'],
					$ticket['uniqid'],
					$title,
					$ticket['department'],
					$ticket['cfor'],
					$ticket['creater'],
					formatDateOrDaysAgo($ticket['date']),
					$status,
					duration($ticket['date'], $ticket['dateresolved']),
					'<a href="view_ticket.php?id='.$ticket["uniqid"].'" class="btn btn-success btn-xs update">View Ticket</a>',
					'<button type="button" name="update" id="' . $ticket["id"] . '" class="btn btn-warning btn-xs update">Edit</button>',
					'<button type="button" name="delete" id="' . $ticket["id"] . '" class="btn btn-danger btn-xs delete">Close</button>'
				);
			}

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

		if (!empty($_POST['subjectName']) && !empty($_POST['message'])) {
			$date = (new DateTime('now', new DateTimeZone('GMT+8')))->getTimestamp();
			$uniqid = uniqid();
			$ticketMessage = mysqli_real_escape_string($this->dbConnect, $_POST['message']);
			$userId = $_SESSION["userid"];
			$name = $_POST["name"];
			$subjId = $_POST["subjectName"];
			$deptId = $_POST["departmentName"];
			$resolved = $_POST["status"];

			// Insert ticket to DB
			$queryInsert = "INSERT INTO {$this->ticketTable} 
				(uniqid, user, createdfor, title, init_msg, department, date, dateresolved, last_reply, user_read, admin_read, resolved) 
				VALUES(?,?,?,?,?,?,?, 'On Progress', 0 ,0 ,0, ?)";

			$result = mysqli_prepare($this->dbConnect, $queryInsert);
			mysqli_stmt_bind_param(
				$result,
				"sisisiii", // corrected type string
				$uniqid,      // s
				$userId,      // i
				$name,        // s
				$subjId,      // i
				$ticketMessage, // s
				$deptId,      // i
				$date,        // i
				$resolved     // i
			);
			mysqli_stmt_execute($result);
			mysqli_stmt_close($result);

			// $queryInsert = "INSERT INTO {$this->ticketTable} 
			// 	(uniqid, user, createdfor, title, init_msg, department, date, dateresolved, last_reply, user_read, admin_read, resolved)
			// 	VALUES('$uniqid', '{$_SESSION["userid"]}', '{$_POST['name']}', '{$_POST['subjectName']}', 
			// 	'$ticketMessage', '{$_POST['departmentName']}', '$date', 'On Progress', 0, 0, 0, '{$_POST['status']}')";
		
			// $result = mysqli_query($this->dbConnect, $queryInsert);

			if($result) {
				$ticketDetails = $this->ticketInfo($uniqid);

				$user = $ticketDetails['creater'];
				$subject = $ticketDetails['subject'];
				$department = $ticketDetails['department'];

				// 📧 Send Email Notification
				require 'vendor/autoload.php'; // If using Composer

				$mail = new PHPMailer\PHPMailer\PHPMailer(true);
	
				$mail->SMTPDebug = 2; // Verbose output
				$mail->Debugoutput = 'error_log'; // Send debug to error_log

				try {
					$mail->isSMTP();
					$mail->isHTML(true);
					$mail->SMTPDebug = 2;
					$mail->Host       = 'smtp.gmail.com';   
					$mail->SMTPAuth   = true;
					$mail->Username   = 'sudayonfernando01@gmail.com';
					$mail->Password   = 'ivfn tofh iych hkdd';    
					$mail->SMTPSecure = 'tls';
					$mail->Port       = 587;

					$mail->setFrom('fpsudayon@oxc-phdepartment.com', 'Ticket System');
					$mail->addAddress('fpsudayon@oxc-ph.com', 'FPSudayon'); 
					$mail->addAddress('ebsantos@oxc-ph.com', 'EBSantos');  


					$mail->Subject = "New Ticket: " . $subject; 
					$mail->Body = "<h3>A new ticket has been submitted!</h3>
						Ticket ID: <i><strong>$uniqid</strong></i><br>
						From: <strong>$user</strong><br>
						Subject: <strong>$subject</strong><br>
						Message: <strong>$ticketMessage</strong>
						<br><br>
						Department: <strong>$department</strong>
					";
					$mail->send();
				} catch (Exception $e) {
					error_log("Mailer Error: {$mail->$e}");
				}

				echo 'success ' . $uniqid;
			}
			

		} else {
			echo '<div class="alert error">Please fill in all fields.</div>';
		}
	}

	// public function createTicket() {      
	// 	if(!empty($_POST['subjectName']) && !empty($_POST['message'])) {                
	// 		$date = new DateTime();
	// 		$date = $date->getTimestamp();
	// 		$uniqid = uniqid();                
	// 		$ticketMessage = mysqli_real_escape_string($this->dbConnect, $_POST['message']);
			
	// 		$queryInsert = "INSERT INTO ".$this->ticketTable." (uniqid, user, createdfor, title, init_msg, department, date, dateresolved, last_reply, user_read, admin_read, resolved) 
	// 		VALUES('".$uniqid."', '".$_SESSION["userid"]."', '".$_POST['name']."', '".$_POST['subjectName']."', '".$ticketMessage."', '".$_POST['departmentName']."', '".$date."', 'On Progress', 0, 0, 0, '".$_POST['status']."')";		
				
	// 		mysqli_query($this->dbConnect, $queryInsert);			
	// 		echo 'success ' . $uniqid;
	// 	} else {
	// 		echo '<div class="alert error">Please fill in all fields.</div>';
	// 	}
	// }	
	
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
			$date = (new DateTime('now', new DateTimeZone('GMT+8')))->getTimestamp();
			$date = $date->getTimestamp();
			if($_POST["status"] == 0) {
				$isresolved = 'On Progress';
				$newDate = $date;
			} else {
				$isresolved = $date;
			}
			
			$updateQuery = "UPDATE ".$this->ticketTable."
			SET createdfor = '".$_POST['name']."', title = '".$_POST["subjectName"]."', department = '".$_POST["departmentName"]."', date = '".$newDate."', init_msg = '".$_POST["message"]."', resolved = '".$_POST["status"]."', dateresolved = '".$isresolved."'
			WHERE id ='".$_POST["ticketId"]."'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);
		}	
	}		
	public function closeTicket(){
		if($_POST["ticketId"]) {
			$date = (new DateTime('now', new DateTimeZone('GMT+8')))->getTimestamp();
			$date = $date->getTimestamp();
			
			$sqlDelete = "UPDATE ".$this->ticketTable." 
				SET resolved = '1', dateresolved = '".$date."'
				WHERE id = '".$_POST["ticketId"]."'";		
			mysqli_query($this->dbConnect, $sqlDelete);		

			// notify user in regards with their ticket
			// re-implement policy to use their corporate email @oxc-ph
			
		}
	}	
	public function getDepartments() {       
		$sqlQuery = "SELECT * FROM ".$this->departmentsTable." 
					WHERE status=1 ORDER BY name ASC";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		while($department = mysqli_fetch_assoc($result) ) {       
            echo '<option value="' . $department['id'] . '">' . $department['name']  . '</option>';           
        }
    }	    
	// Subjects Category
	public function getSubjects() {       
		$sqlQuery = "SELECT * FROM ".$this->subjectsTable."
					WHERE status=1 ORDER BY name ASC";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		while($subject = mysqli_fetch_assoc($result) ) {       
            echo '<option value="' . $subject['id'] . '">' . $subject['name']  . '</option>';           
        }
    }	
	// Get user names
	public function getUsers() {       
		$sqlQuery = "SELECT * FROM ".$this->usersTable."
					WHERE status=1 AND user_type='user' ORDER BY name ASC";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		while($user = mysqli_fetch_assoc($result) ) {       
            echo '<option value="' . $user['id'] . '">' . $user['name']  . '</option>';           
        }
    }	

    public function ticketInfo($id) {  		
		$sqlQuery = "SELECT t.id, u.id AS uId, t.uniqid, t.title, t.user as tUser, t.createdFor as cfor, t.init_msg as tmessage, t.date, t.dateresolved, t.last_reply, t.resolved, u.name as creater, u.user_type as userType, s.name as subject, d.name as department 
			FROM ".$this->ticketTable." t 
			LEFT JOIN hd_users u ON t.user = u.id 
			LEFT JOIN hd_subjects s ON t.title = s.id 
			LEFT JOIN hd_departments d ON t.department = d.id 
			WHERE t.uniqid = '".$id."'";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
        $tickets = mysqli_fetch_assoc($result);
        return $tickets;        
    }    

	public function saveTicketReplies() {
		if (!empty($_POST['message']) && !empty($_POST['ticketId'])) {
			$date = (new DateTime())->getTimestamp();
			$ticketReply = $_POST['message'];
			$ticketId = (int)$_POST['ticketId'];
			$userId = (int)$_SESSION["userid"];

			// $queryInsert = "INSERT INTO hd_ticket_replies (user, text, ticket_id, date, user_read) 
			// 				VALUES ('".$userId."', '".$_POST["message"]."', '".$_POST["ticketId"]."','".$date."', 0)";

			$queryInsert = "INSERT INTO {$this->ticketRepliesTable} (user, text, ticket_id, date, user_read)
							VALUES (?,?,?,?,0)"; 
							
			$insstmt = mysqli_prepare($this->dbConnect, $queryInsert);
			mysqli_stmt_bind_param($insstmt, "isis", $userId, $ticketReply, $ticketId, $date);
			mysqli_stmt_execute($insstmt);
			mysqli_stmt_close($insstmt);
			// if (!mysqli_query($this->dbConnect, $queryInsert)) {
			// 	error_log("MySQL Error: " . mysqli_error($this->dbConnect));
			// 	exit;
			// }

			$updateTicket = "UPDATE {$this->ticketTable} 
                         SET last_reply = ?, user_read = 0, admin_read = 0 
                         WHERE id = ?";
			$updstmt = mysqli_prepare($this->dbConnect, $updateTicket);
			mysqli_stmt_bind_param($updstmt, "ii", $userId, $ticketId);
			mysqli_stmt_execute($updstmt);
			mysqli_stmt_close($updstmt);
			
<<<<<<< HEAD
			$updateTicket = "UPDATE ".$this->ticketTable." 
				SET last_reply = '".$_SESSION["userid"]."', user_read = '0', admin_read = '0' 
				WHERE id = '".$_POST['ticketId']."'";				
			mysqli_query($this->dbConnect, $updateTicket);
		} 
	}	
=======
			$response = [
				"date" => $date,
				"message" => $ticketReply,
				"ticketId" => $ticketId,
				"userId" => $userId,
				"status" => "success"
			];
			echo json_encode($response);
		}	
	}
>>>>>>> refs/remotes/origin/master
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