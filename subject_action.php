<?php
include 'init.php';

if(!empty($_POST['action']) && $_POST['action'] == 'listSubject') {
	$subject->listSubject();
}

if(!empty($_POST['action']) && $_POST['action'] == 'getSubjectDetails') {
	$subject->subjectId = $_POST["subjectId"];
	$subject->getSubjectDetails();
}

if(!empty($_POST['action']) && $_POST['action'] == 'addSubject') {
	$subject->subject = $_POST["subjName"];
    $subject->status = $_POST["status"];    
	$subject->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'updateSubject') {
	$subject->subjectId = $_POST["subjectId"]; 
	$subject->subject = $_POST["subjName"];
    $subject->status = $_POST["status"]; 
	$subject->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'deleteSubject') {
	$subject->subjectId = $_POST["subjectId"];
	$subject->delete();
}
?>