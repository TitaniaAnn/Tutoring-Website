<?php
session_start();
// Session Variables //
unset($_SESSION['userId']);
unset($_SESSION['user']);
unset($_SESSION['first']);
unset($_SESSION['last']);
unset($_SESSION['major']);
unset($_SESSION['phone']);
unset($_SESSION['email']);
unset($_SESSION['discript']);
unset($_SESSION['image']);
unset($_SESSION['tutoring']);
unset($_SESSION['terms']);
unset($_SESSION['args1']);
unset($_SESSION['args2']);
unset($_SESSION['args3']);
unset($_SESSION['args4']);
unset($_SESSION['args5']);
unset($_SESSION['args6']);
unset($_SESSION['args7']);
unset($_SESSION['albany']);
unset($_SESSION['benton']);
unset($_SESSION['lebanon']);
unset($_SESSION['sweethome']);
unset($_SESSION['agree']);
unset($_SESSION['perCourse']);
unset($_SESSION['perDay']);
unset($_SESSION['total']);
unset($_SESSION['renew']);
unset($_SESSION['access']);
unset($_SESSION['desk']);
unset($_SESSION['edit']);
unset($_SESSION['private']);
unset($_SESSION['tutorCourses']);
unset($_SESSION['studentCourses']);
header("location: /tutoring/mockup/home.php");
?>