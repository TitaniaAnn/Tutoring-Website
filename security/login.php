<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

if(isset($_REQUEST['user']))
{
    $user = $_REQUEST['user'];
    $pass = $_REQUEST['password'];

    $result = login($user, $pass);
}

// Session Variables //
if(!isset($_SESSION['user']) || $_SESSION['user'] == 'none')
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}
if($_SESSION['access'] == 'basic')
{
    $title = "Login";
    $script = "../scripts/signup.js";
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<div id="main">
<form id="mainform" name="mainform" action="login.php" method="post" onsubmit="return validateForm()">
    <div id="contents">
        <h2>Login</h2>
        <p>Login to your account</p>
        <div if="signform">
            <ul>
                <li>X-number: <input type="text" name="user" id="user" required="required" /></li>
                <li>Password: <input type="password" name="password" id="password" required="required" /></li>
                <li><input type="reset" value="Reset" /><input type="submit" id="submit" value="Submit" /></li>
                <li><a href="#">Forgot password</a></li>
            </ul>
        </div>
    </div>
</form>
</div>
<?php
    include_once('../include/footer.php');
} else {
    header("location: /tutoring/mockup/welcome.php");
}
?>