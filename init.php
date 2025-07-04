<?php
session_start();
$timeout_duration = 3600;

// introduction.php
// tutorial.php
// tickets.php
// user.php
// Users.php 

include 'config.php';

define('HOST', $host);
define('USER', $username);
define('PASSWORD', $password);
define('DATABASE', $database);
require 'class/Database.php';
require 'class/Users.php';
require 'class/Time.php';
require 'class/Tickets.php';
require 'class/Subject.php';
require 'class/Department.php';
require 'class/Purchase.php';

$database = new Database;
$users = new Users;
$time = new Time;
$subject = new Subject;
$department = new Department;
$tickets = new Tickets;
$purchase = new Purchase;

