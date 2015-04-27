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
    $title = "Stats";
    
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<div id="main">
    <div id="contents">
        <div id="weekly">
            <div class="subject"></div>
            <div class="course"></div>
        </div>
        <div id="term">
            <div class="subject"></div>
            <div class="course"></div>
        </div>
        <div id="all">
            <div class="subject"></div>
            <div class="course"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/security/login.php");
}
?>