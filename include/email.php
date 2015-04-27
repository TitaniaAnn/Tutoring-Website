<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

$title = "Email";

if(isset($_REQUEST['head']))
{
    $email = $_REQUEST['email'];
    $subject = $_REQUEST['subject'];
    $page = $_REQUEST['page'];
    $message = "From:".$email;

    mail("horsefreak21@gmail.com",$subject,$page,$message);
    
    unset($_REQUEST['email']);
    unset($_REQUEST['subject']);
    unset($_REQUEST['page']);
}

// Session Variables //
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['tutoring'] = 0;
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}

$info = getPage($title);
$script = "../scripts/jobs.js";

    include_once('header.php');
    include_once('navigation.php');
?>
<div id="main">
    <div id="contents">
        <form name="input" action="home.php" method="post">
                <ul id="update">
                    <li>Email Address: </li>
                    <li><input type="text" name="email" id="email" /></li>
                    <li>Subject: </li>
                    <li><input type="text" name="subject" id="subject" /></li>
                    <li>Content:</li>
                    <li><textarea id="page" cols="45" rows="15" name="page"><?php echo($page); ?></textarea></li>
                    <li><input type="reset" value="Reset" /><input type="submit" id="submit" value="Submit" /></li>
                </ul>
            </form>
    </div>
</div>
<?php
    include_once('footer.php');
?>