<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

$title = "Users";

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
    $users = getUsers();
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<div id="main">
    <div id="contents">
    <?php
    while($row = mysql_fetch_array($users))
    {
        ?>
        <article>
            <div class="image"></div>
            <div class="data">
                <header>
                    <h4><?php echo($row['FirstName']." ".$row['LastName']); ?></h4>
                    <ul class="classes">
                    <?php
                        $userClass = getUserCourses($row['Id'], "user");
                        if($userClass != false)
                        {
                            foreach($userClass as $key=>$value)
                            {
                                echo("<li class='class".$key."'>".$value."</li>");
                            }
                        }
                    ?>
                    </ul>
                </header>
            </div>
        </article>
        <?php
    }
    ?>
    </div>
</div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/authentication/login.php");
}
?>