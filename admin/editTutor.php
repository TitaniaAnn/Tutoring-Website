<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

$title = "Tutors";

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
    if(isset($_REQUEST['userId']))
    {
        $userId = $_REQUEST['userId'];
        unset($_REQUEST['userId']);
    }
    if(isset($_REQUEST['']))

$tutor = getUserName($userId);
$script = "../scripts/tutor.js";
include_once('../include/header.php');
include_once('../include/navigation.php');
?>
<div id="main">
    <div id="contents">
        <div class="data">
            <h3>Add Tutor</h3>
            <form name="main" id="main" action="editTutor.php" method="post" enctype="multipart/form-data">
                <ul class="classes">
                    <li>First Name: <?php echo($tutor['FirstName']); ?><input type="text" name="first" value="<?php echo($tutor['FirstName']); ?>" /></li>
                    <li>Last Name: <?php echo($tutor['LastName']); ?><input type="text" name="last" value="<?php echo($tutor['LastName']); ?>" /></li>
                    <li>Phone Number: <?php echo($tutor['Phone']); ?><input type="text" name="phone" value="<?php echo($tutor['Phone']); ?>" /></li>
                    <li>Email Address: <?php echo($tutor['Email']); ?><input type="email" name="email" value="<?php echo($tutor['Email']); ?>" /></li>
                    <li>X-Number: <?php echo($tutor['UserName']); ?><input type="text" name="user" value="<?php echo($tutor['UserName']); ?>" /></li>
                    <li>Desk:<input type="checkbox" name="desk" />Edit:<input type="checkbox" name="edit" /></li>
                    <li>Temp Password:<input type="password" name="pass" /></li>
                    <li><input type="submit" name="submit" /></li>
                </ul>
            </form>
        </div>
    </div>
</div>
<?php
include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/security/login.php");
}
?>