<?php
session_start();
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

