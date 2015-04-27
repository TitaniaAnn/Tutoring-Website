<?php
// Connects to database 					(functions.php)
function connectdb() {
    unlock();
    $conn = mysql_connect($_ENV['dbhost'], $_ENV['dbuser'], $_ENV['dbpass']) or die('Error connecting to mysql');
    mysql_select_db($_ENV['dbname'], $conn);
    lock();
}

/***** global variables *****/
$time   = array("08:00AM", "08:30AM", "09:00AM", "09:30AM", "10:00AM", "10:30AM",
				"11:00AM", "11:30AM", "12:00AM", "12:30AM", "01:00PM", "01:30PM",
				"02:00PM", "02:30PM", "03:00PM", "03:30PM", "04:00PM", "04:30PM");
$day	= array( 1 => "Monday", 2 => "Tuesday", 3 => "Wednesday", 4 => "Thursday", 5 => "Friday");
/***** end global variables *****/

/***** Page functions *****/
// get page content 						(home.php, tutorInfo.php, becomeTutor.php, email.php, functions.php)
function getPage($title) {
    connectdb();
    try
    {
        $sql = "SELECT `Heading`, `Page` FROM `pages` WHERE `Title` = '".$title."'";
        $data = mysql_query($sql) or die('Error: '.mysql_error());
        if(mysql_num_rows($data) > 0)
        {
            return mysql_fetch_array($data);
        } else {
            return false;
        }
    }
    catch (Exception $e)
    {
        return false;
    }
}
// update page content 						(home.php, tutorInfo.php, becomeTutor.php)
function updatePage($title, $head, $page) {
    connectdb();
    if(get_magic_quotes_gpc()) {
        $title = stripslashes($title);
        $head = stripslashes($head);
        $page = stripslashes($page);
    }
    $title = stripslashes($title);
    $head = addslashes($head);
    $page = addslashes($page);
    
    $info = getPage($title);
    if(!$info) {
        mysql_query("INSERT INTO `pages` (Title, Heading, Page) VALUES ('".$title."', '".$head."', '".$page."')") or die('Error: '.mysql_error());
        return true;
    } else {
        mysql_query("UPDATE `pages` SET `Heading` = '".$head."', `Page` = '".$page."' WHERE `Title` = '".$title."'") or die('Error: '.mysql_error());
        return true;
    }
}
/***** end Page functions *****/

/***** Job functions *****/
// get all jobs								(becomeTutor.php, jobs.php)
function getJobs() {
    connectdb();
    $data = mysql_query("SELECT * FROM `job`") or die('Error: '.mysql_error());
    return $data;
}
// get a Job								(becomeTutor.php, jobs.php)
function getJob($head, $subject) {
    connectdb();
    $data = mysql_query("SELECT * FROM `job` WHERE (`Title` = '".$head."') AND (`Subject` = '".$subject."')") or die('Error: '.mysql_error());
    return mysql_fetch_array($data);
}
// Add a Job								(jobs.php)
function addJob($head, $subject, $discript, $class) {
    if(get_magic_quotes_gpc()) {
        $head = stripslashes($head);
        $subject = stripslashes($subject);
        $discript = stripslashes($discript);
    }
    $head = addslashes($head);
    $subject = addslashes($subject);
    $discript = addslashes($discript);
    
    connectdb();
    $info = getJob($head, $subject);
    if(!$info) {
        if(!mysql_query("INSERT INTO `job` (`Title`, `Subject`, `Discription`) VALUES ('$head', '$subject', '$discript')")) {
            die('Error: '.mysql_error());
        } else {
            if($class != '' || $class != null || $class != 'none') {
                $info = getJob($head, $subject);
                $id = $info['Id'];
                addJobClass($id, $class);
            }
        }
    } else {
        updateJob($head, $subject, $discript);
        if($class != '' || $class != null || $class != 'none') {
            $info = getJob($head, $subject);
            $id = $info['Id'];
            addJobClass($id, $class);
        }
    }
    
}
// update a Job								(functions.php)
function updateJob($job, $subject, $discript) {
    connectdb();
    if(get_magic_quotes_gpc()) {
        $head = stripslashes($head);
        $subject = stripslashes($subject);
        $discript = stripslashes($discript);
    }
    $head = addslashes($head);
    $subject = addslashes($subject);
    $discript = addslashes($discript);
    
    mysql_query("UPDATE `job` SET `Subject` = '$subject', `Discription` = '$discript' WHERE `Title` = '$job'");
}
// delete a Job								(jobs.php)
function deleteJob($job) {
    connectdb();
    mysql_query("DELETE FROM `job` WHERE `Title` = '$job'") or die('Error: '.mysql_error());
}
// add a course to job						(not used)
function addJobCourse($courseId, $jobId) {
    connectdb();
    $sqla = "SELECT * FROM `job_course` WHERE `JobId` = ".$jobId." AND `CourseId` = ".$courseId."";
    $data = mysql_query($sqla);
    if(mysql_num_rows($data) == 0 || $data == null) {
        $sql = "INSERT INTO `job_course` (`JobId`, `CourseId`) VALUES ('".$jobId."', '".$courseId."')";
        mysql_query($sql) or die('Error: '.mysql_error());
    }
}
// get one course for job					(not used)
function getJobCourseLine($courseId, $jobId) {
    connectdb();
    $sql = "SELECT * FROM `job_course` WHERE `JobId` = ".$jobId." AND `CourseId` = ".$courseId."";
    $data = mysql_query($sql);
    return mysql_num_rows($data);
}
// get a jobs courses						(jobs.php)
function getJobCourse($id) {
    connectdb();
    $sql = "SELECT course.Course, course.Id FROM course INNER JOIN job_course ON course.Id = job_course.CourseId INNER JOIN job ON job_course.JobId = job.Id WHERE (job.Id = '".$id."')";
    $data = mysql_query($sql);
        
    if(mysql_num_rows($data) > 0) {
        while($row = mysql_fetch_array($data)) {
            $class[$row['Id']] = $row['Course'];
        }
        return $class;
    } else {
        return false;
    }
}
// delete course from a job					(not used)
function deleteJobCourse($courseId, $jobId) {
    connectdb();
    mysql_query("DELETE FROM `job_course` WHERE (`CourseId` = '".$courseId."') AND (`JobId` = '".$jobId."')") or die('Error: '.mysql_error());
}
/***** end Job functions *****/

/***** User functions *****/
/***** Student functions *****/
// Working need to deal with courses		(signup.php)
function addStudent($user, $pass, $first, $last, $major, $phone, $email, $course, $tutor, $args, $albany, $benton, $lebanon, $sweethome, $agree) {
    if(get_magic_quotes_gpc()) {
        $user       = stripslashes($user);
        $pass       = stripslashes($pass);
        $first      = stripslashes($first);
        $last       = stripslashes($last);
        $major      = stripslashes($major);
        $phone      = stripslashes($phone);
        $email      = stripslashes($email);
        $albany     = stripslashes($albany);
        $benton     = stripslashes($benton);
        $lebanon    = stripslashes($lebanon);
        $sweethome  = stripslashes($sweethome);
        $agree      = stripslashes($agree);
        foreach($args as $key => $value) {
            $args[$key] = stripslashes($value);
        }
        foreach($course as $key => $value) {
            $course[$key] = stripslashes($value);
        }
        /*foreach($tutor as $key => $value) {
            $tutor[$key] = stripslashes($value);
        }*/
    }
    $user       = addslashes($user);
    $pass       = addslashes($pass);
    $first      = addslashes($first);
    $last       = addslashes($last);
    $major      = addslashes($major);
    $phone      = addslashes($phone);
    $email      = addslashes($email);
    $albany     = addslashes($albany);
    $benton     = addslashes($benton);
    $lebanon    = addslashes($lebanon);
    $sweethome  = addslashes($sweethome);
    $agree      = addslashes($agree);
    foreach($args as $key => $value) {
        $args[$key] = addslashes($value);
    }
    foreach($course as $key => $value) {
        $course[$key] = addslashes($value);
    }
    /*foreach($tutor as $key => $value) {
        $tutor[$key] = addslashes($value);
    }*/
    $pass = md5($pass);
    
    connectdb();
    $sql = "INSERT INTO `user` (`UserName`, `Password`, `Access`, `FirstName`, `LastName`, `Major`, `Phone`, `Email`, `Tutoring`, `Argument1`, `Argument2`, `Argument3`, `Argument4`, `Argument5`, `Argument6`, `Argument7`, `Albany`, `Benton`, `Lebanon`, `SweetHome`, `Agree`) VALUES ('".$user."', '".$pass."', 'student', '".$first."', '".$last."', '".$major."', '".$phone."', '".$email."', '1', '".$args[0]."', '".$args[1]."', '".$args[2]."', '".$args[3]."', '".$args[4]."', '".$args[5]."', '".$args[6]."', '".$albany."', '".$benton."', '".$lebanon."', '".$sweethome."', '".$agree."')";
    mysql_query($sql) or die('Error: '.mysql_error());
}
/***** end Student functions *****/

/***** Tutor functions *****/
// add a tutor								(tutors.php)
function addTutor($user, $pass, $first, $last, $phone, $email) {
    connectdb();
    if(get_magic_quotes_gpc()) {
        $user       = stripslashes($user);
        $pass       = stripslashes($pass);
        $first      = stripslashes($first);
        $last       = stripslashes($last);
        $phone      = stripslashes($phone);
        $email      = stripslashes($email);
    }
    $user       = addslashes($user);
    $pass       = addslashes($pass);
    $first      = addslashes($first);
    $last       = addslashes($last);
    $phone      = addslashes($phone);
    $email      = addslashes($email);
    $pass = md5($pass);
    
    $sql = "INSERT INTO `user` (`UserName`, `Password`, `Access`, `FirstName`, `LastName`, `Major`, `Phone`, `Email`) VALUES ('".$user."', '".$pass."', 'tutor', '".$first."', '".$last."', 'none', '".$phone."', '".$email."')";
    mysql_query($sql) or die('Error: '.mysql_error());
    $page = "An acount has been created for you. Please log on and change you password.\n".
            "Name: '$first' '$last'\n".
            "Phone: '$phone'\n".
            "Email: '$email'\n".
            "UserName: '$UserName' - Please change to your X-Number\n".
            "Password: '$pass'";
    mail($email,"LBCC Tutoring Desk - Tutoring Account Created",$page,"From: Tutor.Desk@linnbenton.edu");
}

// get all tutors							(meetTutor.php, tutors.php)
function getTutors() {
    connectdb();
    $sql = "SELECT * FROM `user` WHERE `Access` = 'tutor'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0) {
        return $data;
    } else {
        return false;
    }
}
// get all tutors that tutor in a class		(appointments.php)
function getAllCourseTutors($courseId) {
	connectdb();
    $sql = "SELECT user.* FROM `user`, `user_course` WHERE `user_course.CourseId` = '".$courseId."' AND `user_course.Type` = 'tutor' AND `user.Id` = `user_course.UserId`";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0) {
		$tutors = array();
		while($row = mysql_fetch_array($data))
		{
			$tutors[$row['Id']] = $row;
		}
        return $tutors;
    } else {
        return false;
    }
}

/***** end Tutor functions *****/
/***** generic User functions *****/

// delete course from user					(profile.php)
function deleteUserCourse($courseId, $userId, $type) {
    connectdb();
    mysql_query("DELETE FROM `user_course` WHERE (`CourseId` = '".$courseId."') AND (`UserId` = '".$userId."') AND (`Type` = '".$type."')") or die('Error: '.mysql_error());
}
// add class to user						(profile.php)
function addUserCourse($courseId, $userId, $type) {
    connectdb();
    if(get_magic_quotes_gpc()) {
        $courseId       = stripslashes($courseId);
        $userId         = stripslashes($userId);
        $type           = stripslashes($type);
    }
    $courseId       = addslashes($courseId);
    $userId         = addslashes($userId);
    $type           = addslashes($type);

    $sqla = "SELECT * FROM `user_course` WHERE `JobId` = ".$jobId." AND `CourseId` = ".$courseId."AND (`Type` = '".$type."')";
    $data = mysql_query($sqla);
    if(mysql_num_rows($data) == 0 || $data == null) {
        $sql = "INSERT INTO `job_course` (`JobId`, `CourseId`, `Type`) VALUES ('".$jobId."', '".$courseId."', '".$type."')";
        mysql_query($sql) or die('Error: '.mysql_error());
    }
}


// update user								(not used)
function updateUser($user){
    
}
// delete user								(not used)
function deleteUser($user) {
    connectdb();
    mysql_query("DELETE FROM `user` WHERE `UserName` = '".$user."'") or die('Error: '.mysql_error());
}
// user login								(login.php, signup.php)
function login($user, $pass) {
    if(get_magic_quotes_gpc()) {
        $user = stripslashes($user);
        $pass = stripslashes($pass);
    }
    $user = addslashes($user);
    $pass = addslashes($pass);
    $pass = md5($pass);
    connectdb();
    $sql = "SELECT * FROM `user` WHERE `UserName` = '$user' AND `Password` = '$pass'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) == 1) {
        $info = mysql_fetch_array($data);
        $_SESSION['userId']         = $info['Id'];
        $_SESSION['user']           = $info['UserName'];
        $_SESSION['first']          = $info['FirstName'];
        $_SESSION['last']           = $info['LastName'];
        $_SESSION['major']          = $info['Major'];
        $_SESSION['phone']          = $info['Phone'];
        $_SESSION['email']          = $info['Email'];
        $_SESSION['discript']       = $info['Discript'];
        $_SESSION['image']          = $info['Image'];
        $_SESSION['tutoring']       = $info['Tutoring'];
        if($_SESSION['tutoring']) {
            $_SESSION['terms']      = $info['Terms'];
            $_SESSION['arg1']      = $info['Argument1'];
            $_SESSION['arg2']      = $info['Argument2'];
            $_SESSION['arg3']      = $info['Argument3'];
            $_SESSION['arg4']      = $info['Argument4'];
            $_SESSION['arg5']      = $info['Argument5'];
            $_SESSION['arg6']      = $info['Argument6'];
            $_SESSION['arg7']      = $info['Argument7'];
            $_SESSION['albany']     = $info['Albany'];
            $_SESSION['benton']     = $info['Benton'];
            $_SESSION['lebanon']    = $info['Lebanon'];
            $_SESSION['sweethome']  = $info['SweetHome'];
            $_SESSION['agree']      = $info['Agree'];
            $_SESSION['perCourse']  = $info['AllowedPerCourse'];
            $_SESSION['perDay']     = $info['AllowedPerDay'];
            $_SESSION['total']      = $info['AllowedTotal'];
        }
        $_SESSION['renew']          = $info['Renew'];
        $_SESSION['access']         = $info['Access'];
        $_SESSION['desk']           = $info['Desk'];
        $_SESSION['edit']           = $info['Edit'];
        $_SESSION['private']        = $info['Private'];
        
        if($_SESSION['access'] == 'tutor') {
            $_SESSION['tutorCourses'] = getUserCourses($_SESSION['userId'], $_SESSION['access']);
        }
        if($_SESSION['tutoring'] == 1) {
            $_SESSION['studentCourses'] = getUserCourses($_SESSION['userId'], 'student');
        }
        //getCourses();
        return true;
    } else {
        print '<script type="text/javascript">'; 
        print 'alert("UserName / Password not found.")';
        print '</script>';
        return false;
    }
}
// get user courses							(meetTutor.php, calendars.php, students.php, tutors.php, profile.php, functions.php)
function getUserCourses($id, $type) {
    connectdb();
    $sql = "SELECT course.Course, course.Id FROM course INNER JOIN user_course ON course.Id = user_course.CourseId INNER JOIN user ON user_course.UserId = user.Id WHERE (user.Id = '".$id."') AND (user_course.Type = '".$type."')";
    $data = mysql_query($sql);
    
    if(mysql_num_rows($data) > 0) {
        while($row = mysql_fetch_array($data)) {
            $course[$row['Id']] = $row['Course'];
        }
        return $course;
    } else {
        return false;
    }
}
// get all users							(students.php, profile.php)
function getUsers() {
    connectdb();
    $sql = "SELECT * FROM `user` WHERE `Tutoring` = '1'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0) {
        return $data;
    } else {
        return false;
    }
}
/***** end generic User functions *****/
/***** end user functions *****/

/***** Course functions *****/
// get a course								(appointments.php)
function getCourse($course) {
    connectdb();
    $data = mysql_query("SELECT * FROM `course` WHERE (`Id` = '".$course."')");
    return mysql_fetch_array($data);
}
// get all courses							(jobs.php, courses.php, signup.php)
function getCourses() {
    connectdb();
    $sql = "SELECT * FROM `course` ORDER BY `Course` ASC";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0) {
        return $data;
    } else {
        return false;
    }
}
// 											(courses.php)
function getSubjectCourses($subject) {
    connectdb();
    $courseData = mysql_query("SELECT * FROM `course` WHERE `Subject` = '".$subject."' ORDER BY `Course` ASC");
    if(mysql_num_rows($courseData) > 0) {
        return $courseData;
    } else {
        return false;
    }
}
// 											(courses.php)
function getSubjects() {
    connectdb();
    $subject = array();
    $subjectData = mysql_query("SELECT * FROM `subjects` ORDER BY `Name` ASC");
    if(mysql_num_rows($subjectData) > 0) {
        return $subjectData;
    } else {
        return false;
    }
}
// 											(courses.php)
function addCourse($course, $name, $subjectId) {
    connectdb();
    $sql = "INSERT INTO `course` (`Course`, `Name`, `Subject`) VALUES ('".$course."', '".$name."', '".$subjectId."')";
    mysql_query($sql) or die('Error: '.mysql_error());
}
// 											(courses.php)
function removeCourse($courseId) {
    connectdb();
    $sql = "DELETE FROM `course` WHERE `Id` = '".$courseId."'";
    mysql_query($sql) or die('Error: '.mysql_error());
}
// 											(courses.php)
function addSubject($subject) {
    connectdb();
    $sql = "INSERT INTO `subjects` (`Name`) VALUES ('".$subject."')";
    mysql_query($sql) or die('Error: '.mysql_error());
}
// 											(courses.php)
function removeSubject($subjectId) {
    connectdb();
    $sql = "DELETE FROM `subjects` WHERE `Id` = '".$subjectId."'";
    mysql_query($sql) or die('Error: '.mysql_error());
    
}
// get courses tutors						(calenders.php)
function getCourseTutor($courseId) {
    connectdb();
    $sql = "SELECT * FROM `user_course` WHERE `CourseId` = '".$courseId."' AND `Type` = 'tutor'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0) {
        while($row = mysql_fetch_array($data)) {
            $tutorData = mysql_query("SELECT `FirstName`, `LastName` FROM `user` WHERE `Id` = '".$row['UserId']."'");
            if(mysql_num_rows($tutorData) > 0) {
                while($tutorRow = mysql_fetch_array($tutorData)) {
					$name['Id']		= $row['UserId'];
					$name['Course']	= $row['CourseId'];
                    $name['Name'] 	= $tutorRow['FirstName']." ".$tutorRow['LastName'];
                    $tutor[$name['Id']] = $name;
                }
            }
        }
        return $tutor;
    } else {
        return false;
    }
}
/***** end Course functions *****/

/***** Notice and Hold functions *****/
// get notices								(welcome.php)
function getNotices($type) {
    connectdb();
    $sql = "SELECT * FROM `notices` WHERE `Level` = '".$type."'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        return $data;
    } else {
        return false;
    }
}

/***** end Notice and Hold functions *****/
/***** calender functions *****/

// get tutor calender						(calendars.php)
function getNextAppointments($tutorId) {
    connectdb();
    $monday         = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(1-date('w'))+7,date("o")));
    $tuesday        = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(2-date('w'))+7,date("o")));
    $wednesday      = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(3-date('w'))+7,date("o")));
    $thursday       = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(4-date('w'))+7,date("o")));
    $friday         = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(5-date('w'))+7,date("o")));
    $sql = "SELECT * FROM `appointments` WHERE `TutorId` = ".$tutorId." AND (`Date` = '".$monday."' OR `Date` = '".$tuesday."' OR `Date` = '".$wednesday."' OR `Date` = '".$thursday."' OR `Date` = '".$friday."')";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}

// add perm calender						(calendars.php)
function addPermCalendar($tutorId, $day, $time, $location, $available) {
    connectdb();
    $currentDate    = date("o-m-d");
    $term = mysql_query("SELECT `Id`, `Term` FROM `term` WHERE `EndDate` > '".$currentDate."' ORDER BY `EndDate` DESC");
    if(mysql_num_rows($term) > 0)
    {
        while($rows = mysql_fetch_array($term))
        {
            echo($rows['Term']);
            $row = $rows;
        }
    }
    /*if($location == '') {
        $location = 'Albany';
    }*/
    $sql = "INSERT INTO `cal_perm` (`TutorId`, `Term`, `Day`, `Time`, `Location`, `Available`)
        VALUES ('".$tutorId."', '".$row."', '".$day."', '".$time."', '".$location."', '".$available."')";
    mysql_query($sql) or die('Error: '.mysql_error());
}

// get temp calender						(cal.php)
function getNextTempCalendar($userId) {
    connectdb();
    $currentWeekDay = date('w');
    $monday         = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(1-date('w'))+7,date("o")));
    $tuesday        = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(2-date('w'))+7,date("o")));
    $wednesday      = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(3-date('w'))+7,date("o")));
    $thursday       = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(4-date('w'))+7,date("o")));
    $friday         = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(5-date('w'))+7,date("o")));
    
    $sql = "SELECT * FROM `cal_temp` WHERE `TutorId` = '".$tutorId."' AND `Approve` = '1' AND (`Date` = '".$monday."' OR `DATE` = '".$tuesday."' OR `DATE` = '".$wednesday."' OR `DATE` = '".$thursday."' OR `DATE` = '".$friday."') ORDER BY `Date` ASC";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}


// get daily student appointments			(not used)
function getCurrentStudentApointments($userId) {
    connectdb();
    $monday         = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(1-date('w')),date("o")));
    $tuesday        = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(2-date('w')),date("o")));
    $wednesday      = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(3-date('w')),date("o")));
    $thursday       = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(4-date('w')),date("o")));
    $friday         = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(5-date('w')),date("o")));
    $sql = "SELECT * FROM `appointments` WHERE `Date` = '".$currentDate."' AND `StudentId` = '".$userId."'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
// get weekly student appointments			(not used)
function getWeekStudentApointments($userId) {
    connectdb();
    $currentDate    = date("o-m-d");
    $sql = "SELECT * FROM `appointments` WHERE `StudentId` = '".$userId."' AND (`Date` = '".$monday."' OR `Date` = '".$tuesday."' OR `Date` = '".$wednesday."' OR `Date` = '".$thursday."' OR `Date` = '".$friday."'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
// get daily tutor appointments				(not used)
function getCurrentTutorApointments($tutorId) {
    connectdb();
    $currentDate    = date("o-m-d");
    $sql = "SELECT * FROM `appointments` WHERE `Date` = '".$currentDate."' AND `TutorId` = '".$tutorId."'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
// get weekly tutor appointments			(not used)
function getWeekTutorApointments($tutorId) {
    connectdb();
    $currentDate    = date("o-m-d");
    $sql = "SELECT * FROM `appointments` WHERE `TutorId` = '".$tutorId."' AND `Date` = '".$currentDate."'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
//											(not used)
function getWeeklyAppointments() {
    connectdb();
    $currentDate    = date("o-m-d");
    $sql = "SELECT * FROM `appointments` WHERE `Date` = '".$currentDate."'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
// get user name for Appointments			(cal.php, appointments.php, editTutor.php)
function getUserName($userId) {
    connectdb();
    $sql = "SELECT * FROM `user` WHERE `Id` = '".$userId."'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        return mysql_fetch_array($data);
    } else {
        return false;
    }
}
// get all tutors daily appointments 		(appointments.php)
function getDailyAppointments($date) {
    connectdb();
    $sql = "SELECT * FROM appointments WHERE `Date` = '".$date."' ORDER BY `Time` ASC";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
// get a tutor's daily appointments 		(appointments.php)
function getTutorDailyAppointments($tutorId, $date) {
	connectdb();
    $sql = "SELECT * FROM `appointments` WHERE `Date` = '".$date."' AND `TutorId` = '".$tutorId."'";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
// get tutor calender						(cal.php)
function getTutorAppointments($tutorId) {
    connectdb();
    $monday         = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(1-date('w')),date("o")));
    $friday         = date("o-m-d", mktime(0,0,0,date("m"),date("d")+(5-date('w')),date("o")));
    $sql = $sql = "SELECT * FROM `appointments` WHERE `TutorId` = '".$tutorId."' AND `Date` >= '".$monday."' AND `Date` <= '".$friday."' ORDER BY `Date` ASC";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
// update appointment						(appointments.php)
function updateAppointment($id, $tutor, $time, $canceled, $showed, $late, $noShowed, $notes) {
	connectdb();
}
// update add cal_perm						(calendar.php)
function updatePermCalendar($tutorId, $term, $day, $time, $location, $available) {
	connectdb();
	$check = "SELECT * FROM `cal_perm` WHERE `TutorId` = '".$tutorId."' AND `Term` = '".$term."' AND `Day` = '".$day."' AND `Time` = '".$time."'";
	$data = mysql_query($check);
	if(mysql_num_rows($data) > 0) {
		$sql = "UPDATE `cal_perm` SET `NewLocation` = '".$location."', `NewAvailable` = '".$available."', `Approve` = '0' WHERE `TutorId` = '".$tutorId."' AND `Term` = '".$term."' AND `Day` = '".$day."' AND `Time` = '".$time."'";
		mysql_query($sql) or die('Error: '.mysql_error());
	} else if($available == true) {
		$sql = "INSERT INTO `cal_perm` (`TutorId`, `Term`, `Day`, `Time`, `Location`, `Available`) VALUES ('".$tutorId."', '".$term."', '".$day."', '".$time."', '".$location."', '".$available."')";
		mysql_query($sql) or die('Error: '.mysql_error());
	}
}
// get perm calender for tutor					(calendars.php)
function getPermCalendar($tutorId, $term) {
    connectdb();
    $sql = "SELECT * FROM `cal_perm` WHERE `TutorId` = '".$tutorId."' AND `Term` = '".$term."' ORDER BY `Day` ASC";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
// get temp calender						(calendars.php)
function getTempCalendar($tutorId, $term) {
    connectdb();
    $sql = "SELECT * FROM `cal_temp` WHERE `TutorId` = '".$tutorId."' AND `Term` = '".$term."' ORDER BY `Date` ASC";
    $data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
//	add row to tempCalender										(calendars.php)
function updateTempCalendar($tutorId, $term, $date, $day, $time, $location, $available) {
    connectdb();
    $check = "SELECT * FROM `cal_temp` WHERE `TutorId` = '".$tutorId."' AND `Term` = '".$term."' AND `Date` = '".$date."' AND `Day` = '".$day."' AND `Time` = '".$time."'";
	$data = mysql_query($check);
	if(mysql_num_rows($data) > 0) {
		$sql = "UPDATE `cal_temp` SET `Location` = '".$location."', `Available` = '".$available."', `Approve` = '0' WHERE `TutorId` = '".$tutorId."' AND `Term` = '".$term."' AND `Date` = '".$date."' AND `Day` = '".$day."' AND `Time` = '".$time."'";
		mysql_query($sql) or die('Error: '.mysql_error());
	} else if($available == true) {
		$sql = "INSERT INTO `cal_temp` (`TutorId`, `Term`, `Date`, `Day`, `Time`, `Location`, `Available`) VALUES ('".$tutorId."', '".$term."', '".$date."', '".$day."', '".$time."', '".$location."', '".$available."')";
		mysql_query($sql) or die('Error: '.mysql_error());
	}
}
/***** end Calender functions *****/
// update image								(profile.php)
function updateImg($userId,  $fileName) {
    if(get_magic_quotes_gpc())
    {
        $userId     = stripslashes($userId);
        $fileName   = stripslashes($fileName);
    }
    $userId     = addslashes($userId);
    $fileName   = addslashes($fileName);
    connectdb();
    
    $sql = "UPDATE `user` SET `Image` = '".$fileName."' WHERE `Id` = '".$userId."'";
    mysql_query($sql);
}

// get list of terms						(calendar.php)
function getTerms() {
	connectdb();
	$current = date("o-m-d");
	$sql = "SELECT * FROM `term` WHERE `EndDate` >= '".$current."' ORDER BY `StartDate` ASC";
	$data = mysql_query($sql);
    if(mysql_num_rows($data) > 0)
    {
        $info = array();
        while($row = mysql_fetch_array($data))
        {
            $info[$row['Id']] = $row;
        }
        return $info;
    } else {
        return false;
    }
}
?>