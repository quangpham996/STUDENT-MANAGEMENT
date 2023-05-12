<?php
// router
session_start();
// import config & connectDB
require 'config.php';
require 'connectDB.php';

// require model
require 'model/StudentRepository.php';
require 'model/Student.php';

require 'model/SubjectRepository.php';
require 'model/Subject.php';

require 'model/RegisterRepository.php';
require 'model/Register.php';

// http://qlsvmvc.com/?c=subject&a=create

$c = $_GET['c'] ?? 'student';
$a = $_GET['a'] ?? 'index';
$strController = ucfirst($c) . 'Controller'; //e.g: StudentController

// controller/StudentController.php
require "controller/$strController.php";

// $controller = new StudentController();
$controller = new $strController();
$controller->$a();
