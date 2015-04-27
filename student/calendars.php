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

if($_SESSION['tutoring'] == 1)
{
    $title 		= "Tutoring Schedules";
	$style		= "../styles/calendar.css";
    $script 	= "../scripts/calendar.js";
	$courses	= getUserCourses($_SESSION['userId'], 'student');
	
    include_once('../include/header.php');
    include_once('../include/navigation.php');
    ?>
    <div id="main">
        <div id="contents">
            <h2></h2>
            <p>Course Name:
                <select id="course" onChange="studentChangeCourse(this.value)">
                    <option value=''></option>
                    <?php
						if($courses != false) {
							foreach($courses as $key => $value) {
								echo("<option value='".$key."'>".$value."</option>");
							}
						}
                    ?>
                </select>
                Tutor's:
                <select id="tutor" onChange="showTutorCalendar(this.value)">
                    <option value=''></option>
                    <?php
						if($courses != false) {
							foreach($courses as $key => $value) {
								$tutor = getCourseTutor($key);
								if($tutor != false) {
									foreach($tutor as $nvalue)
									{
										echo("<option value='".$nvalue['Id']."' class='".$key." hidden'>".$nvalue['Name']."</option>");
									}
                                }
							}
						}
                    ?>
                </select>
            </p>
            <div id="calendar">
                <div class="week">
                    <div class="day">
                        <div class='time bord'></div>
                        <?php
                            foreach($time as $t)
                            {
                                ?>
                                <div class='time bord'><?php echo($t); ?></div>
                                <?php
                            }
                        ?>
                    </div>
                <?php foreach($day as $d) { 
                    echo('<div class="day '.$d.'">');
                        echo('<div class="time bord">'.$d.'</div>');
                    echo('</div>');
                } ?>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/security/login.php");
}
?>