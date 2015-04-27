<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

// Session Variables //
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['tutoring'] = 0;
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}

if($_SESSION['access'] == 'tutor') {
	if(isset($_REQUEST['perm'])) {
		updatePermCalendar($_REQUEST['tutorId'], $_REQUEST['term'], $_REQUEST['day'], $_REQUEST['time'], $_REQUEST['location'], $_REQUEST['available']);
		unset($_REQUEST['perm']);
		unset($_REQUEST['tutorId']);
		unset($_REQUEST['term']);
		unset($_REQUEST['day']);
		unset($_REQUEST['time']);
		unset($_REQUEST['location']);
		unset($_REQUEST['available']);
	}
	if(isset($_REQUEST['temp'])) {
		updateTempCalendar($_REQUEST['tutorId'], $_REQUEST['term'], $_REQUEST['date'], $_REQUEST['day'], $_REQUEST['time'], $_REQUEST['location'], $_REQUEST['available']);
		unset($_REQUEST['temp']);
		unset($_REQUEST['tutorId']);
		unset($_REQUEST['term']);
		unset($_REQUEST['date']);
		unset($_REQUEST['day']);
		unset($_REQUEST['time']);
		unset($_REQUEST['location']);
		unset($_REQUEST['available']);
	}
} else {
    header ("location: /tutoring/mockup/security/login.php");
}
?>