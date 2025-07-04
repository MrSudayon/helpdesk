<<<<<<< HEAD
<?php
include 'init.php';
if(!empty($_POST['action']) && $_POST['action'] == 'auth') {
	$users->login();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listRequests') {
	// $purchase->showPurchaseReqForm();
}
if(!empty($_POST['action']) && $_POST['action'] == 'purchaseRequest') { 
	// $purchase->createPurchaseReqForm();
    // print_r("createTicket");
		if ($purchase->createPurchaseReqForm($_POST)) {
			echo "New record created successfully";
		} else {
			echo "Error creating record";
		}
	
}


// if(!empty($_POST['action']) && $_POST['action'] == 'getTicketDetails') {
// 	// $tickets->getTicketDetails();
//     echo "getTicketDetails";
// }
// if(!empty($_POST['action']) && $_POST['action'] == 'updateTicket') {
// 	// $tickets->updateTicket();
//     echo "updateTicket";
// }
// if(!empty($_POST['action']) && $_POST['action'] == 'closeTicket') {
// 	// $tickets->closeTicket();
//     echo "closeTicket";
// }
// if(!empty($_POST['action']) && $_POST['action'] == 'saveTicketReplies') {
// 	// $tickets->saveTicketReplies();
//     echo "saveTicketReplies";
// }


=======
<?php
include 'init.php';
if(!empty($_POST['action']) && $_POST['action'] == 'auth') {
	$users->login();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listRequests') {
	// $purchase->showPurchaseReqForm();
}
if(!empty($_POST['action']) && $_POST['action'] == 'purchaseRequest') { 
	// $purchase->createPurchaseReqForm();
    // print_r("createTicket");
		if ($purchase->createPurchaseReqForm($_POST)) {
			echo "New record created successfully";
		} else {
			echo "Error creating record";
		}
	
}


// if(!empty($_POST['action']) && $_POST['action'] == 'getTicketDetails') {
// 	// $tickets->getTicketDetails();
//     echo "getTicketDetails";
// }
// if(!empty($_POST['action']) && $_POST['action'] == 'updateTicket') {
// 	// $tickets->updateTicket();
//     echo "updateTicket";
// }
// if(!empty($_POST['action']) && $_POST['action'] == 'closeTicket') {
// 	// $tickets->closeTicket();
//     echo "closeTicket";
// }
// if(!empty($_POST['action']) && $_POST['action'] == 'saveTicketReplies') {
// 	// $tickets->saveTicketReplies();
//     echo "saveTicketReplies";
// }


>>>>>>> master
?>