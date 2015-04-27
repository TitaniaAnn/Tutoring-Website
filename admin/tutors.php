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
if(isset($_REQUEST['user']) && isset($_REQUEST['pass']))
{
    addTutor($_REQUEST['user'], $_REQUEST['pass'], $_REQUEST['first'], $_REQUEST['last'], $_REQUEST['phone'], $_REQUEST['email']);
    unset($_REQUEST['first']);
    unset($_REQUEST['last']);
    unset($_REQUEST['phone']);
    unset($_REQUEST['email']);
    unset($_REQUEST['user']);
    unset($_REQUEST['pass']);
}
if($_SESSION['access'] == 'admin')
{
$tutors = getTutors();
$script = "../scripts/tutor.js";
include_once('../include/header.php');
include_once('../include/navigation.php');
?>
<div id="main">
    <div id="contents">
        <form name="tutor" id="tutor" action="editTutor.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="userId" id="userId" />
<?php
    while($row = mysql_fetch_array($tutors))
    {
?>
        <article>
            
            <div class="image">
<?php
                if($row['Image'] != null)
                {
?>
                <img src="../<?php echo($row['Image']); ?>" alt="<?php echo($row['FirstName']." ".$row['LastName']); ?>" />
<?php
                }
?>
            </div>
            <div class="data">
                <header>
                    <h4><?php echo($row['FirstName']." ".$row['LastName']); ?></h4>
                    <ul class="classes">
<?php
                        $tutorClass = getUserCourses($row['Id'], "tutor");
                        if($tutorClass != false)
                        {
                            foreach($tutorClass as $key=>$value)
                            {
                                echo("<li class='class".$key."'>".$value."</li>");
                            }
                        }
?>
                    </ul>
                </header>
                <p>
                    <?php echo($row['Discription']); ?>
                </p>
            </div>
            <input type="submit" name="edit" id="<?php echo($row['Id']); ?>" class="edit" value="Edit" />
        </article>
<?php
    }
?>
        </form>
        <div class="data">
            <h3>Add Tutor</h3>
            <form name="main" id="main" action="tutors.php" method="post" enctype="multipart/form-data">
                <ul class="classes">
                    <li>First Name:<input type="text" name="first" /></li>
                    <li>Last Name:<input type="text" name="last" /></li>
                    <li>Phone Number: <input type="text" name="phone" /></li>
                    <li>Email Address: <input type="email" name="email" /></li>
                    <li>X-Number:<input type="text" name="user" /></li>
                    <li>Temp Password:<input type="password" name="pass" /></li>
                    <li><input type="reset" name="reset" /><input type="submit" name="submit" /></li>
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