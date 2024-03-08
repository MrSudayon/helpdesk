<?php
class Database {    

	private $dbConnect = false;
	private $ticketsTable = 'hd_tickets';

    public function dbConnect() {        
        static $DBH = null;      
        if (is_null($DBH)) {              
			$connection = new mysqli(HOST, USER, PASSWORD, DATABASE);			
			if($connection->connect_error){
				die("Error failed to connect to MySQL: " . $connection->connect_error);
			} else {
				$DBH = $connection;
			}         
        }
        return $DBH;    
    } 
    public function __construct(){		
        $this->dbConnect = $this->dbConnect();
    } 
    public function openTicketCount() {
        // Status countss
        if()
        $sqlQuery = "SELECT * FROM ". $this->ticketsTable ."";
        $result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = $result->num_rows;
		echo json_encode($row);
    }    
}