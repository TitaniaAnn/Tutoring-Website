<?php
session_start();
include_once('scripts/config.php');
include_once('scripts/functions.php');

$title = "Home";

if(isset($_REQUEST['head']))
{
    $head = $_REQUEST['head'];
    $page = $_REQUEST['page'];

    $result = updatePage($title, $head, $page);
    unset($_REQUEST['head']);
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
$head = $info['Heading'];
$page = $info['Page'];
$script = "scripts/jobs.js";

    include_once('include/header.php');
    include_once('include/navigation.php');
?>
<div id="main">
    <div id="contents">
        <?php
            echo("<h2>$head</h2>");
            echo("<div id='htext'>$page</div>");
        ?>
    </div>
<?php
    if($_SESSION['edit'])
    {
?>
        <div id="edit">
            <form name="input" action="home.php" method="post">
                <ul id="update">
                    <li>Heading: </li>
                    <li><input type="text" name="head" id="head" value="<?php echo($head); ?>" /></li>
                    <li>Content:</li>
                    <li><textarea id="page" cols="45" rows="15" name="page"><?php echo($page); ?></textarea></li>
                    <li><input type="reset" value="Reset" /><input type="submit" id="submit" value="Submit" /></li>
                </ul>
            </form>
        </div>
<?php
    }
?>
</div>
<?php
    include_once('include/footer.php');
?>