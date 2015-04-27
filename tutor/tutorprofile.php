<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

$title = "Users";
if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
    if($action == 'delete')
    {
        $classId = $_REQUEST['classId'];
        $jobId = $_REQUEST['jobId'];
        deleteUserClass($classId, $jobId, "user");
    }
    if($action == 'add')
    {
        $classId = $_REQUEST['classId'];
        $jobId = $_REQUEST['jobId'];
        addUserClass($classId, $jobId, "user");
    }
    unset($_REQUEST['action']);
    unset($_REQUEST['classId']);
    unset($_REQUEST['jobId']);
}
if(isset($_REQUEST['phone']) && $_REQUEST['phone'] != '')
{
    $phone      = $_REQUEST['phone'];
    $email      = $_REQUEST['email'];
    $tutor      = $_REQUEST['tutoring']; 

    addJob($head, $subject, $discript, $class);
    unset($_REQUEST['phone']);
    unset($_REQUEST['email']);
}
// Session Variables //
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}

if(($_SESSION['access'] == 'user' && $_SESSION['tutoring'])|| ($_SESSION['access'] == 'tutor' && $_SESSION['tutoring']))
{
    $script = "../scripts/jobs.js";
    $users = getUsers();
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<div id="main">
<form name="mainform" id="mainform" action="tutorprofile.php" method="post">
    <input type="hidden" name="action" id="action" />
    <input type="hidden" name="classId" id="classId" />
    <input type="hidden" name="jobId" id="jobId" />
    <div id="contents">
        <h2><?php echo($_SESSION['first']." ".$_SESSION['last']); ?> - Profile</h2>
        <h3>Main Content</h3>
        <ul>
            <li>X-number:       <?php echo($_SESSION['user']); ?></li>
            <li>First Name:     <?php echo($_SESSION['first']); ?></li>
            <li>Last Name:      <?php echo($_SESSION['last']); ?></li>
            <li>Phone Number:   <?php echo($_SESSION['phone']."\t<input type='test' id='phone' value='".$_SESSION['phone']."' />"); ?></li>
            <li>Email Address:  <?php echo($_SESSION['email']."\t<input type='test' id='phone' value='".$_SESSION['email']."' />"); ?></li>
            <li>Use Tutoring:   <?php echo("<input type='checkbox' id='tutoring' value='".$_SESSION['tutoring']."' />"); ?></li>
            <li><button type='submit' class='update'>Update</button></li>
        </ul>
        <h3>Classes</h3>
        <ul>
        <?php
            $userClass = getUserClasses($_SESSION['userId'], 'tutor');
            if($userClass != false)
            {
                foreach($userClass as $key=>$value)
                {
                    echo("<li class='class".$key."'>".$value."<button type='submit' class='".$_SESSION['userId']." delete' >Delete</button></li>");
                }
            }
            echo("<li>Add Class: <select name='classes' id='classes' class='".$_SESSION['userId']."'><option value=''></option>");
                foreach($_SESSION['allClasses'] as $key=>$value)
                {
                    echo("<option value='".$key."'>".$value."</option>");
                } 
            echo("</select><button type='submit' class='".$_SESSION['userId']." add' >Add Class</button></li>");
        ?>
        </ul>
    </div>
</form>
</div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/authentication/login.php");
}
?>