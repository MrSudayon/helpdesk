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
    public function __construct() {		
        $this->dbConnect = $this->dbConnect();
    } 

    public function allTicketCount() {
        $sql = "SELECT COUNT(*) AS count FROM ". $this->ticketsTable;
        $result = mysqli_query($this->dbConnect, $sql);	
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    public function openTicketCount() {
        $sql = "SELECT COUNT(*) AS count FROM ". $this->ticketsTable ." WHERE resolved = 0";
        $result = mysqli_query($this->dbConnect, $sql);	
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    public function closedTicketCount() {
        $sql = "SELECT COUNT(*) AS count FROM ". $this->ticketsTable ." WHERE resolved = 1";
        $result = mysqli_query($this->dbConnect, $sql);	
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    
}