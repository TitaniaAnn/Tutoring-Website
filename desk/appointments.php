<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

// Session Variables //
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}

if($_SESSION['access'] == 'admin')
{
    $time   = array("08:00AM", "08:30AM", "09:00AM", "09:30AM", "10:00AM", "10:30AM",
                    "11:00AM", "11:30AM", "12:00AM", "12:30AM", "01:00PM", "01:30PM",
                    "02:00PM", "02:30PM", "03:00PM", "03:30PM", "04:00PM", "04:30PM");
    $title = "Daily Appointments";
	$script = "../scripts/appoint.js";
    
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<div id="main">
    <div id="contents">
    	<form id="updateAppointments" action="appointments.php" method="post">
    	<h2>Appointments for <?php 
			if(date(G) > 17) {
				echo(date("l", mktime(0,0,0,date("m"),date("d")+1,date("o")))." - ".date("m/d/o", mktime(0,0,0,date("m"),date("d")+1,date("o"))));
				$appointments = getDailyAppointments(date("o-m-d", mktime(0,0,0,date("m"),date("d")+1,date("o"))));
			} else {
				echo(date("l")." - ".date("m/d/o", mktime(0,0,0,date("m"),date("d"),date("o"))));
				$appointments = getDailyAppointments(date("o-m-d", mktime(0,0,0,date("m"),date("d"),date("o"))));
			} 
		?></h2><div class="print">print</div>
    	<div id="appointments">
        
            <div class="hKey">
                <div class="tutor">Tutor</div>
                <div class="student">Student</div>
                <div class="courseApp">Course</div>
            </div>
            <ul id="timeList">
        <?php
		foreach($time as $value)
		{
			echo('<li class="timeRow">'.$value);	
			if($appointments != false)
        	{	
				echo('<ul>');
				foreach($appointments as $app)
				{
					if($app['Time'] == $value)
					{
						$tutor = getUserName($app['TutorId']);
						$student = getUserName($app['StudentId']);
						$course = getCourse($app['Course']);
						?>
						<li class="appRow">
                        	<div class="tutor">
							<?php echo($tutor['FirstName']." ".substr($tutor['LastName'], 0, 1)); ?>
							<span class="hidden phone"><?php echo($tutor['Phone']); ?></span></div>
                            <div class="student">
							<?php echo($student['FirstName']." ".substr($student['LastName'], 0, 1)); ?>
							<span class="hidden phone"><?php echo($student['Phone']); ?></span></div>
							<div class="courseApp"><?php echo($course['Course']); ?></div>
                            <div class="input">
                            	<input type="hidden" name="id[]" value="<?php echo($app['Id']); ?>" />
                            	<label for="showed<?php echo($app['Id']); ?>"><input type="checkbox" name="showed[]" id="showed<?php echo($app['Id']); ?>" class="showed" <?php if($app['Showed'] == 1) { echo('checked="true"'); } ?> />Showed</label>
                                <label for="late<?php echo($app['Id']); ?>"><input type="checkbox" name="late[]" id="late<?php echo($app['Id']); ?>" class="late" <?php if($app['Late'] == 1) { echo('checked="true"'); } ?> />Late</label>
                                <label for="noshowed<?php echo($app['Id']); ?>"><input type="checkbox" name="noshowed[]" id="noshowed<?php echo($app['Id']); ?>" class="noshow" <?php if($app['NoShowed'] == 1) { echo('checked="true"'); } ?> />No-Showed</label>
                              	<label for="canceled<?php echo($app['Id']); ?>"><input type="checkbox" name="canceled[]" id="canceled<?php echo($app['Id']); ?>" class="canceled" <?php if($app['Canceled'] == 1) { echo('checked="true"'); } ?> />Canceled</label>
                                <label class="notes" for="notes<?php echo($app['Id']); ?>">Notes<input type="text" name="notes[]" id="notes<?php echo($app['Id']); ?>" <?php if($app['Canceled'] == 1) { echo('value="Canceled: '.$app['CanceledTime'].'"'); } ?> /></label>
                            <div class="show">
                            	<a class="call">call</a>
                                <a class="change">change</a>
                                <!--<a class="notice">Notice</a>-->
                            </div>
                            </div>
                            <div class="hidden changediv">
                            	<label for="time<?php echo($app['Id']); ?>">Time</label>
                                <select name="time[]" id="time<?php echo($app['Id']); ?>">
                                	<?php
									foreach($time as $t) {
										if($t == $value) {
											echo('<option value="'.$t.'" selected="true">'.$t.'</option>');
										} else {
											echo('<option value="'.$t.'">'.$t.'</option>');
										}
									}
									?>
                                </select>
                            	<label for="tutor<?php echo($app['Id']); ?>">Tutor</label>
                                <select name="tutor[]" id="tutor<?php echo($app['Id']); ?>">
                                	<?php
									$tutors = getAllCourseTutors($app['Course']);
									foreach($tutors as $t) {
										if($t['Id'] == $tutor['Id']) {
											echo('<option value="'.$t['Id'].'" selected="true">'.$t['FirstName'].' '.$t['LastName'].'</option>');
										} else {
											echo('<option value="'.$t['Id'].'">'.$t['FirstName'].' '.$t['LastName'].'</option>');
										}
									}
									?>
                                </select>
                                <input type="submit" value="Submit Changes" />
                            </div>
                            <!--<div class="addNotice">
                            	
                            </div>-->
						</li>
						<?php
					}
				}
				echo('</ul>');
			}
			echo('</li>');
		}
		?>
			</ul> 
        </div>
        
        <input type="submit" value="Update" />
        </form>
        <div class="clear"></div>
        <div class="hidden" id="print">
        	<h2>Appointments for <?php 
				if(date(G) > 18) {
					echo(date("l", mktime(0,0,0,date("m"),date("d")+1,date("o")))." - ".date("m/d/o", mktime(0,0,0,date("m"),date("d")+1,date("o"))));
				} else {
					echo(date("l")." - ".date("m/d/o", mktime(0,0,0,date("m"),date("d"),date("o"))));
				} 
			?></h2><div class="print">close</div>
            <div id="appointments">
                <ul id="timeList-left">
                <li class="hKey">
                	<div class="tutor">Tutor</div>
                    <div class="student">Student</div>
                    <div class="courseApp">Course</div>
                </li>
            <?php
            foreach($time as $value)
            {
				if($value == "12:30AM") {
					echo('</ul>');
					echo('<ul id="timeList-right"><li class="hKey"><div class="tutor">Tutor</div><div class="student">Student</div><div class="courseApp">Course</div></li>');
				}
                echo('<li class="timeRow">'.$value);	
                if($appointments != false)
                {	
                    echo('<ul>');
                    foreach($appointments as $app)
                    {
                        if($app['Time'] == $value)
                        {
                            $tutor = getUserName($app['TutorId']);
                            $student = getUserName($app['StudentId']);
                            $course = getCourse($app['Course']);
                            ?>
                            <li class="appRow">
                                <div class="tutor"><?php echo($tutor['FirstName']." ".substr($tutor['LastName'], 0, 1)); ?></div>
                                <div class="student"><?php echo($student['FirstName']." ".substr($student['LastName'], 0, 1)); ?></div>
                                <div class="courseApp"><?php echo($course['Course']); ?></div>
                            </li>
                            <?php
                        }
                    }
                    echo('</ul>');
                }
                echo('</li>');
            }
            ?>
                </ul>
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