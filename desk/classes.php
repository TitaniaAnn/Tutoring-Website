<?php
session_start();

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
    $title = "Settings";

    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
    <div id="contents">
        <h2>Settings</h2>
        <p>Some info here</p>
    </div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/authentication/login.php");
}
?>