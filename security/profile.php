<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

$title = "Users";
if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
    if($action == 'delete')
    {
        $classId = $_REQUEST['classId'];
        $jobId = $_REQUEST['jobId'];
        deleteUserCourse($classId, $jobId, "user");
    }
    if($action == 'add')
    {
        $classId = $_REQUEST['classId'];
        $jobId = $_REQUEST['jobId'];
        addUserCourse($classId, $jobId, "user");
    }
    unset($_REQUEST['action']);
    unset($_REQUEST['classId']);
    unset($_REQUEST['jobId']);
}
if(isset($_REQUEST['title']) && $_REQUEST['title'] != '')
{
    $head       = $_REQUEST['phone'];
    $subject    = $_REQUEST['email'];

    //
    unset($_REQUEST['phone']);
    unset($_REQUEST['email']);
}
if(isset($_FILES['imgFile']) && (($_FILES["imgFile"]["type"] == "image/jpeg") || ($_FILES["imgFile"]["type"] == "image/pjpeg")) && ($_FILES["imgFile"]["size"] < 20000))
{
    if($_FILES['imgFile']['error'] > 0)
    {
        echo("<script type='text/javascript'>");
        echo("alert('Error: " . $_FILES["imgFile"]["error"]."');");
        echo("</script>");
    } else {
        if(file_exists("tutorImg/" . $_FILES["imgFile"]["name"]) && $_SESSION['access'] != 'admin')
        {
            echo("<script type='text/javascript'>");
            echo("alert('".$_FILES["imgFile"]["name"] . " already exists.');");
            echo("</script>");
        } else {
            move_uploaded_file($_FILES["imgFile"]["tmp_name"], "tutorImg/" . $_FILES["imgFile"]["name"]);
            updateImg($_SESSION['user'],  $_FILES["imgFile"]["name"]);
            echo("<script type='text/javascript'>");
            echo("alert('Stored in: " . "tutorImg/" . $_FILES["imgFile"]["name"]."');");
            echo("</script>");
        }
    }
}
// Session Variables //
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}

if($_SESSION['access'] != 'basic')
{
    $script = "../scripts/profile.js";
    $users = getUsers();
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<div id="main">
<form name="mainform" id="mainform" action="userprofile.php" method="post" enctype="multipart/form-data">
    <div id="contents">
        <h2><?php echo($_SESSION['first']." ".$_SESSION['last']); ?> - Profile</h2>
        <h3>Main Content</h3>
        <ul>
            <li>X-Number:       <?php echo($_SESSION['user']);
            if($_SESSION['access'] == 'tutor' || $_SESSION['access'] == 'admin')
            {?>
                <span class="hidden" id="userInput">
                    <input type="text" id="user" value="<?php echo($_SESSION['user']); ?>" />
                </span><input type="button" value="edit" id="editUser" />
            <?php } ?>
            </li>
            <li>Change Password:
                <span class="hidden" id="userInput">
                    Old Password:<input type="password" name="old-pass" id="old-pass" /><br />
                    New Password:<input type="password" name="new-pass" id="new-pass" /><br />
                    Re-Password:<input type="password" name="re-pass" id="re-pass" /><br />
                </span><input type="button" value="New Password" id="newPass" />
            </li>
            <li>First Name:     <?php echo($_SESSION['first']);  if($_SESSION['access'] == 'admin')
            {?>
                <span class="hidden" id="fnameInput">
                    <input type="text" id="user" value="<?php echo($_SESSION['first']); ?>" />
                </span><input type="button" value="edit" id="editfname" />
            <?php } ?>
            </li>
            <li>Last Name:      <?php echo($_SESSION['last']);
            if($_SESSION['access'] == 'admin')
            {?>
                <span class="hidden" id="lnameInput">
                    <input type="text" id="user" value="<?php echo($_SESSION['last']); ?>" />
                </span><input type="button" value="edit" id="editlname" />
            <?php } ?>
            </li>
            <li>Phone Number:   <?php echo($_SESSION['phone']); ?>
                <span class="hidden" id="phoneInput">
                    <input type="text" id="phone" value="<?php echo($_SESSION['phone']); ?>" />
                </span><input type="button" value="edit" id="editPhone" />
            </li>
            <li>Email Address:  <?php echo($_SESSION['email']); ?>
                <span class="hidden" id="emailInput">
                    <input type="email" id="phone" value="<?php echo($_SESSION['email']); ?>" />
                </span><input type="button" value="edit" id="editEmail" />
            </li>
            
    <?php
    if($_SESSION['access'] == 'tutor' || $_SESSION['access'] == 'admin')
    {
    ?>
            <li><label for="bio">Bio:</label></li>
            <li><textarea name="bio" id="bio" cols="75" rows="15"><?php echo($_SESSION['discript']); ?></textarea></li>
            <li><img src="<?php echo($_SESSION['tutorImg']); ?>" title="tutorImg" /></li>
            <li><input type="file" name="imgFile" /></li>
    <?php
    }
    if($_SESSION['access'] == 'student' || $_SESSION['access'] == 'tutor')
    {
    ?>
            <li>Major: <input type="text" name="major" id="major" value="<?php echo($_SESSION['major']); ?>" />
                <span class="hidden" id="majorInput">
                    <input type="email" id="phone" value="<?php echo($_SESSION['major']); ?>" />
                </span><input type="button" value="edit" id="editMajor" />
            </li>
            <li>Tutoring: <input type="checkbox" name="tutoring" id="tutoring" checked="<?php if($_SESSION['terms'])echo("checked"); ?>" /></li>
            <li><h4>Registration Agreement. Please read and initial each item below:</h4></li>
        <?php
        if(($_SESSION['arg1'] != '' || $_SESSION['arg1'] != NULL) && isset($_SESSION['arg1']))
        { ?>
            <li class="args"><input type="text" name="args[]" id="arg1" value="<?php echo($_SESSION['arg1']); ?>" readonly="readonly" /><p>I agree to attend class, and that I will not schedule tutoring appointments during class.</p></li>
        <?php
        } else {
            ?>
            <li class="args"><input type="text" name="args[]" id="arg1" value="<?php echo($_SESSION['arg1']); ?>" /><p>I agree to attend class, and that I will not schedule tutoring appointments during class.</p></li>
            <?php
        }
        if(($_SESSION['arg2'] != '' || $_SESSION['arg2'] != NULL) && isset($_SESSION['arg2']))
        { ?>
            <li class="args"><input type="text" name="args[]" id="arg2" value="<?php echo($_SESSION['arg2']); ?>" readonly="readonly" /><p>I understand that the Tutoring Program Coordinator will notify my instructor in order to varify my class attendance.</p></li>
            <?php
        } else {
            ?>
            <li class="args"><input type="text" name="args[]" id="arg2" value="<?php echo($_SESSION['arg2']); ?>" /><p>I understand that the Tutoring Program Coordinator will notify my instructor in order to varify my class attendance.</p></li>
            <?php
        }
        if(($_SESSION['arg3'] != '' || $_SESSION['arg3'] != NULL) && isset($_SESSION['arg3']))
        { ?>
            <li class="args"><input type="text" name="args[]" id="arg3" value="<?php echo($_SESSION['arg3']); ?>" readonly="readonly" /><p>I agree to arrive on time.</p></li>
            <?php
        } else {
            ?>
            <li class="args"><input type="text" name="args[]" id="arg3" value="<?php echo($_SESSION['arg3']); ?>" /><p>I agree to arrive on time.</p></li>
            <?php
        }
        if(($_SESSION['arg4'] != '' || $_SESSION['arg4'] != NULL) && isset($_SESSION['arg4']))
        { ?>
            <li class="args"><input type="text" name="args[]" id="arg4" value="<?php echo($_SESSION['arg4']); ?>" readonly="readonly" /><p>I understand that if I am more then 5 minutes late, that my appointment may be filled by the Tutor Coordinator.</p></li>
            <?php
        } else {
            ?>
            <li class="args"><input type="text" name="args[]" id="arg4" value="<?php echo($_SESSION['arg4']); ?>" /><p>I understand that if I am more then 5 minutes late, that my appointment may be filled by the Tutor Coordinator.</p></li>
            <?php
        }
        if(($_SESSION['arg5'] != '' || $_SESSION['arg5'] != NULL) && isset($_SESSION['arg5']))
        { ?>
            <li class="args"><input type="text" name="args[]" id="arg5" value="<?php echo($_SESSION['arg5']); ?>" readonly="readonly" /><p>I agree to cancel my tutoring appointments at least 2 hours in advance. Failure to show up for a tutoring appointment without canceling is a <strong>no-show</strong>. I understand that after <strong>one no-show</strong>, I will lose my tutoring eligibility for <strong>TWO WEEKS</strong>.</p></li>
            <?php
        } else {
            ?>
            <li class="args"><input type="text" name="args[]" id="arg5" value="<?php echo($_SESSION['arg5']); ?>" /><p>I agree to cancel my tutoring appointments at least 2 hours in advance. Failure to show up for a tutoring appointment without canceling is a <strong>no-show</strong>. I understand that after <strong>one no-show</strong>, I will lose my tutoring eligibility for <strong>TWO WEEKS</strong>.</p></li>
            <?php
        }
        if(($_SESSION['arg6'] != '' || $_SESSION['arg6'] != NULL) && isset($_SESSION['arg6']))
        { ?>
            <li class="args"><input type="text" name="args[]" id="arg6" value="<?php echo($_SESSION['arg6']); ?>" readonly="readonly" /><p>I agree to bring my textbook and course materials to each tutoring session, and to let my tutor know how to help me most effectively</p></li>
            <?php
        } else {
            ?>
            <li class="args"><input type="text" name="args[]" id="arg6" value="<?php echo($_SESSION['arg6']); ?>" /><p>I agree to bring my textbook and course materials to each tutoring session, and to let my tutor know how to help me most effectively</p></li>
            <?php
        }
        if(($_SESSION['arg7'] != '' || $_SESSION['arg7'] != NULL) && isset($_SESSION['arg7']))
        { ?>
            <li class="args"><input type="text" name="args[]" id="arg7" value="<?php echo($_SESSION['arg7']); ?>" readonly="readonly" /><p>I understand that some tutoring sessions may need to be shared with a small group.</p></li>
            <?php
        } else {
            ?>
            <li class="args"><input type="text" name="args[]" id="arg7" value="<?php echo($_SESSION['arg7']); ?>" /><p>I understand that some tutoring sessions may need to be shared with a small group.</p></li>
            <?php
        } ?>
            <li class="place">
                <input type="text" name="albany" id="albany" value="<?php echo($_SESSION['albany']); ?>" /><p>Albany</p>
                <input type="text" name="benton" id="benton" value="<?php echo($_SESSION['benton']); ?>" /><p>Benton Center</p>
                <input type="text" name="lebanon" id="lebanon" value="<?php echo($_SESSION['lebanon']); ?>" /> <p>Lebanon Center</p>
                <input type="text" name="sweethome" id="sweethome" value="<?php echo($_SESSION['sweethome']); ?>" /><p>Sweet Home</p>
            </li>
            <li class="agree">Agree to Terms: <input type="checkbox" name="terms" id="terms" checked="<?php if($_SESSION['terms'])echo("checked"); ?>"  /></li>
    <?php
    }
    ?>
            <li><button type='submit' class='update'>Update</button></li>
    <?php
    if($_SESSION['access'] == 'tutor')
    {
    ?>
        <input type="hidden" name="tutorAction" id="tutorAction" />
        <input type="hidden" name="tutorClassId" id="tutorClassId" />
        <input type="hidden" name="tutorJobId" id="tutorJobId" />
        <h3>Tutor - Classes</h3>
        <ul>
        <?php
            $userClass = getUserCourses($_SESSION['userId'], "tutor");
            if($userClass != false)
            {
                foreach($userClass as $key=>$value)
                {
                    echo("<li class='class".$key."'>".$value."<button type='submit' class='".$_SESSION['userId']." delete' >Delete</button></li>");
                }
            }
            echo("<li>Add Class: <select name='classes' id='classes' class='".$_SESSION['userId']."'><option value=''></option>");
                foreach($_SESSION['allClasses'] as $key=>$value)
                {
                    echo("<option value='".$key."'>".$value."</option>");
                } 
            echo("</select><button type='submit' class='".$_SESSION['userId']." add' >Add Class</button></li>");
        ?>
        </ul>
    </div>
</form>
</div>
<?php
    }
    if($_SESSION['tutoring'])
    {
    ?>
        <input type="hidden" name="studentAction" id="studentAction" />
        <input type="hidden" name="studentClassId" id="studentClassId" />
        <input type="hidden" name="studentJobId" id="studentJobId" />
        <h3>Student - Classes</h3>
        <ul>
        <?php
            $userClass = getUserCourses($_SESSION['userId'], "student");
            if($userClass != false)
            {
                foreach($userClass as $key=>$value)
                {
                    echo("<li class='class".$key."'>".$value."<button type='submit' class='".$_SESSION['userId']." delete' >Delete</button></li>");
                }
            }
            echo("<li>Add Class: <select name='classes' id='classes' class='".$_SESSION['userId']."'><option value=''></option>");
                foreach($_SESSION['allClasses'] as $key=>$value)
                {
                    echo("<option value='".$key."'>".$value."</option>");
                } 
            echo("</select><button type='submit' class='".$_SESSION['userId']." add' >Add Class</button></li>");
        ?>
        </ul>
    </div>
</form>
</div>
<?php
    }
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/authentication/login.php");
}
?>