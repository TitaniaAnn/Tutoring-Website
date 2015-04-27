<?php
session_start();
include_once('scripts/config.php');
include_once('scripts/functions.php');

$title = "Welcome";
$script = "scripts/jobs.js";
// Session Variables //
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['tutoring'] = 0;
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}
if(isset($_SESSION['user']) && $_SESSION['user'] != 'none')
{
    include_once('include/header.php');
    include_once('include/navigation.php');
?>
<div id="main">
    <div id="contents">
        <?php
            echo("<h2>Welcome ".$_SESSION['first']." ".$_SESSION['last']."</h2>");
        ?>
        <div id="alerts">
            <h3>Alerts</h3>
            <ul>
                <?php
                if($_SESSION['hold'])
                {
                    echo("<li>There is a hold on your account because: ".$_SESSION['alert']."</li>");
                    echo("<li>The hold will be removed 2 weeks from ".$_SESSION['holdDate']."</li>");
                } else if($_SESSION['alert'] != '') {
                   echo("<li>".$_SESSION['alert']."</li>");
                } else {
                    echo("<li>None</li>");
                }
                ?>
            </ul>
        </div>
        <div id="notices">
            <h3>Notices - Personal</h3>
            <ul>
                <?php
                if($_SESSION['notice'] != '')
                {
                    echo("<li>".$_SESSION['notice']."</li>");
                } else {
                    echo("<li>None</li>");
                }
                ?>
            </ul>
            <?php
            if($_SESSION['access'] == "tutor")
            {
                $tdata = getNotices("tutor");
                ?>
            <h3>Notices - Tutors</h3>
            <ul>
                <?php
                if($tdata != false)
                {
                    while($row = mysql_fetch_array($tdata))
                    {
                        echo("<li>".$row['Notice']."</li>");
                    }
                } else {
                    echo("<li>None</li>");
                }
                ?>
            </ul>
            <?php
            }
            if($_SESSION['access'] == "user" || $_SESSION['tutoring'])
            {
                $udata = getNotices("user");
                ?>
            <h3>Notices - Users</h3>
            <ul>
                <?php
                if($udata != false)
                {
                    while($row = mysql_fetch_array($udata))
                    {
                        echo("<li>".$row['Notice']."</li>");
                    }
                } else {
                    echo("<li>None</li>");
                }
                ?>
            </ul>
            <?php
            }
            ?>
        </div>
        <?php
            echo("<p>$page</p>");
        ?>
    </div>
</div>
<?php
    include_once('include/footer.php');
} else {
    header ("location: /tutoring/mockup/security/login.php");
}
?>