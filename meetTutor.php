<?php
session_start();
include_once('scripts/config.php');
include_once('scripts/functions.php');

$title = "Meet the Tutors";

// Session Variables //
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['tutoring'] = 0;
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}
$script = "scripts/jobs.js";
$tutors = getTutors();
include_once('include/header.php');
include_once('include/navigation.php');
?>
<div id="main">
    <div id="contents">
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
                <img src="<?php echo($row['Image']); ?>" alt="<?php echo($row['FirstName']." ".$row['LastName']); ?>" />
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
                <p><?php echo($row['Discription']); ?></p>
            </div>
        </article>
        <?php
    }
    ?>
    </div>
</div>
<?php
include_once('include/footer.php');
?>
