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
if(isset($_REQUEST['cText']))
{
    $course     = $_REQUEST['cText'];
    $name       = $_REQUEST['name'];
    $subject    = $_REQUEST['subject'];
    addCourse($course, $name, $subject);
    unset($_REQUEST['cText']);
    unset($_REQUEST['name']);
    unset($_REQUEST['subject']);
}
if(isset($_REQUEST['rCourse']))
{
    $course     = $_REQUEST['rCourse'];
    removeCourse($course);
    unset($_REQUEST['rCourse']);
}
if(isset($_REQUEST['sText']))
{
    $subject     = $_REQUEST['sText'];
    addSubject($subject);
    unset($_REQUEST['sText']);
}
if(isset($_REQUEST['rSubject']))
{
    $subject     = $_REQUEST['rSubject'];
    removeSubject($subject);
    unset($_REQUEST['rSubject']);
}
if($_SESSION['access'] == 'admin')
{
    $title = "Courses";
    $subjects = getSubjects();
    $allCourses = getCourses();
    $subjectArray = array();
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<div id="main">
    <div id="contents">
        <h2>Courses by Subject</h2>
        <div id="courses">
        <?php
        while($row = mysql_fetch_array($subjects))
        {
            $subjectArray[$row['Id']] = $row['Name'];
            ?>
            <div class="sub">
            <h3><?php echo($row['Name']); ?></h3>
            <hr />
            <ul id="<?php echo($row['Name']); ?>">
            <?php
                $courses = getSubjectCourses($row['Id']);
            if($courses != false)
            {
                while($cRow = mysql_fetch_array($courses))
                {
                    ?>
                    <li><?php echo($cRow['Course']."&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;".$cRow['Name']); ?></li>
                    <?php
                }
            }
            ?>
            </ul>
            </div>
            <?php
        }
        ?>
        <div class="clear"></div>
        </div>
        <div id="addRemove">
            <div class="add">
                <h3>Add Course</h3>
                <form id="addCourse" action="courses.php" method="post">
                <p>Course Id: 
                    <input type="text" name="cText" id="cText" />
                    Course Name: 
                    <input type="text" name="name" id="name" />
                    Subject: 
                    <select name="subject" id="subject">
                        <option value=''></option>
                    <?php
                        foreach($subjectArray as $key => $value)
                        {
                            echo("<option value='".$key."' class='".$key."'>".$value."</option>");
                        }   
                    ?>
                    </select>
                    <input type="submit" value="Add Subject" />
                </p>
                </form>
            </div>
            <div class="remove">
                <h3>Remove Course</h3>
                <form id="removeCourse" action="courses.php" method="post">
                <p>Course Id: 
                    <select name="rCourse" id="rCourse">
                    <option value=''></option>
                    <?php
                        while($row = mysql_fetch_array($allCourses))
                        {
                            echo("<option value='".$row['Id']."'>".$row['Course']." - ".$row['Name']."</option>");
                        }
                    ?>
                    </select>
                    <input type="submit" value="Delete Course" />
                </p>
                </form>
            </div>
        </div>
        <div id="subject">
            <div class="add">
                <h3>Add Subject</h3>
                <form id="addSubject" action="courses.php" method="post">
                <p>Subject Name: 
                    <input type="text" name="sText" id="sText" />
                    <input type="submit" value="Add Subject" />
                </p>
                </form>
            </div>
            <div class="remove">
                <h3>Remove Subject</h3>
                <form id="removeSubject" action="courses.php" method="post">
                <p>Subject Name: 
                    <select name="rSubject" id="rSubject">
                        <option value=''></option>
                    <?php
                        foreach($subjectArray as $key => $value)
                        {
                            echo("<option value='".$key."' class='".$key."'>".$value."</option>");
                        }   
                    ?>
                    </select>
                    <input type="submit" value="Delete Subject" />
                </p>
                </form>
            </div>
        </div>
        </form>
    </div>
</div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/security/login.php");
}
?>