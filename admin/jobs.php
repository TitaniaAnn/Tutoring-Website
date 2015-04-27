<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

$title = "Jobs";
if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
    if($action == 'delete')
    {
        $classId = $_REQUEST['classId'];
        $jobId = $_REQUEST['jobId'];
        deleteJobClass($classId, $jobId);
    }
    if($action == 'add')
    {
        $classId = $_REQUEST['classId'];
        $jobId = $_REQUEST['jobId'];
        addJobClass($classId, $jobId);
    }
    unset($_REQUEST['action']);
    unset($_REQUEST['classId']);
    unset($_REQUEST['jobId']);
}
if(isset($_REQUEST['title']) && $_REQUEST['title'] != '')
{
    $head       = $_REQUEST['title'];
    $subject    = $_REQUEST['subject'];
    $discript   = $_REQUEST['discript'];
    $class      = $_REQUEST['classes'];

    addJob($head, $subject, $discript, $class);
    unset($_REQUEST['title']);
    unset($_REQUEST['subject']);
    unset($_REQUEST['discript']);
    unset($_REQUEST['classes']);
}

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
    $script = "../scripts/jobs.js";
    $data = getCourses();
    $jobs = getJobs();
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<div id="main">
<form name="mainform" id="mainform" action="jobs.php" method="post">
    <input type="hidden" name="action" id="action" />
    <input type="hidden" name="classId" id="classId" />
    <input type="hidden" name="jobId" id="jobId" />
    <div id="contents">
        <h2>Jobs - ( add / edit / delete )</h2>
        <div id="joblist">
        <?php
            if(mysql_num_rows($jobs) > 0)
            {
                while($row = mysql_fetch_array($jobs))
                {
                    echo("<div class='job' id='job".$row['Id']."'>");
                        echo("<header>");
                            echo("<h2>".$row['Title']."</h2>");
                            echo("<hr />");
                            echo("<h4>Subject: ".$row['Subject']."</h4>");
                            echo("<p>".$row['Discription']."</p>");
                        echo("</header>");
                        echo("<ul class='classes'>");
                            $jobClass = getJobCourse($row['Id']);
                            if($jobClass != false)
                            {
                                foreach($jobClass as $key=>$value)
                                {
                                    echo("<li id='".$key."'>".$value." <button type='submit' class='".$row['Id']." delete' >Delete</button></li>");
                                }
                            }
                            echo("<li>Add Class: <select name='classes' id='classes' class='".$row['Id']."'><option value=''></option>");
                                while($course = mysql_fetch_array($data))
                                {
                                    echo("<option value='".$course['Id']."'>".$course['Course']." - ".$course['Name']."</option>");
                                }
                            echo("</select><button type='submit' class='".$row['Id']." add' >Add Class</button></li>");
                        echo("</ul>");
                        echo("<hr />");
                    echo("</div>");
                }
            }
        ?>
        </div>
        <div id="jobform">
            <h3>Add Job</h3>
            <ul id="form">
                <li>Title: <input type="text" name="title" /></li>
                <li>Subject: <input type="text" name="subject" /></li>
                <li>Discription: </li>
                <li><textarea name="discript" cols="45" rows="15"></textarea></li>
                <li>Add Class: <select name='classes' id='classes'>
                    <option value=''></option>
                <?php
                    foreach($_SESSION['allClasses'] as $key=>$value)
                    {
                        echo("<option value='$key'>$value</option>");
                    }
                ?>
                </select></li>
                <li><input type="reset" id="reset" value="Reset" /><input type="submit" id="submit" value="Submit" /></li>
            </ul>
        </div>
    </div>
</form>
</div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/security/login.php");
}
?>