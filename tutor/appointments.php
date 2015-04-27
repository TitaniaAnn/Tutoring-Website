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
	$time   = array("08:00AM", "08:30AM", "09:00AM", "09:30AM", "10:00AM", "10:30AM",
                    "11:00AM", "11:30AM", "12:00AM", "12:30AM", "01:00PM", "01:30PM",
                    "02:00PM", "02:30PM", "03:00PM", "03:30PM", "04:00PM", "04:30PM");
    $title  = "Tutor's Calendar";
	$script = "../scripts/appoint.js"; 
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<div id="main">
<div id="contents">
	<h2>Appointments for <?php 
		if(date(G) > 17) {
			echo(date("l", mktime(0,0,0,date("m"),date("d")+1,date("o")))." - ".date("m/d/o", mktime(0,0,0,date("m"),date("d")+1,date("o"))));
			$appointments = getTutorDailyAppointments($_SESSION['userId'], date("o-m-d", mktime(0,0,0,date("m"),date("d")+1,date("o"))));
		} else {
			echo(date("l")." - ".date("m/d/o", mktime(0,0,0,date("m"),date("d"),date("o"))));
			$appointments = getTutorDailyAppointments($_SESSION['userId'], date("o-m-d", mktime(0,0,0,date("m"),date("d"),date("o"))));
		}
	?></h2>
	<div id="appointments">
		<ul id="timeList">
		<li class="hKey">
			<div class="tutor">Tutor</div>
			<div class="student">Student</div>
			<div class="courseApp">Course</div>
		</li>
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
                            <div class="student"><?php echo($student['FirstName']." ".substr($student['LastName'], 0, 1)); ?></div>
							<div class="courseApp"><?php echo($course['Course']); ?></div>
                            <div class="input">
                            	<label for="showed<?php echo($app['Id']); ?>"><input type="checkbox" name="showed[]" id="showed<?php echo($app['Id']); ?>" class="showed" <?php if($app['Showed'] == 1) { echo('checked="true"'); } ?> disabled="disabled" />Showed </label>
                                <label for="late<?php echo($app['Id']); ?>"><input type="checkbox" name="late[]" id="late<?php echo($app['Id']); ?>" class="late" <?php if($app['Late'] == 1) { echo('checked="true"'); } ?> disabled="disabled" />Late </label>
                                <label for="noshowed<?php echo($app['Id']); ?>"><input type="checkbox" name="noshowed[]" id="noshowed<?php echo($app['Id']); ?>" class="noshow" <?php if($app['NoShowed'] == 1) { echo('checked="true"'); } ?> disabled="disabled" />No-Showed </label>
                              	<label for="canceled<?php echo($app['Id']); ?>"><input type="checkbox" name="canceled[]" id="canceled<?php echo($app['Id']); ?>" class="canceled" <?php if($app['Canceled'] == 1) { echo('checked="true"'); } ?> disabled="disabled" />Canceled </label>
                                <label class="notes" for="notes<?php echo($app['Id']); ?>"> Notes <textarea name="notes[]" id="notes<?php echo($app['Id']); ?>" rows="1" cols="30" disabled="disabled"><?php if($app['Canceled'] == 1) { echo('Canceled: '.$app['CanceledTime'].' - '.$app['Notes']); } else { echo($app['Notes']); } ?></textarea></label>
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
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/security/login.php");
}
?>