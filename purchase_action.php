<?php
include 'init.php';
if(!empty($_POST['action']) && $_POST['action'] == 'auth') {
	$users->login();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listTicket') {
	// $tickets->showTickets();
    echo "listTicket";
}
if(!empty($_POST['action']) && $_POST['action'] == 'createTicket') {
	// $tickets->createTicket();
    echo "createTicket";
}
if(!empty($_POST['action']) && $_POST['action'] == 'getTicketDetails') {
	// $tickets->getTicketDetails();
    echo "getTicketDetails";
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateTicket') {
	// $tickets->updateTicket();
    echo "updateTicket";
}
if(!empty($_POST['action']) && $_POST['action'] == 'closeTicket') {
	// $tickets->closeTicket();
    echo "closeTicket";
}
if(!empty($_POST['action']) && $_POST['action'] == 'saveTicketReplies') {
	// $tickets->saveTicketReplies();
    echo "saveTicketReplies";
}
?>