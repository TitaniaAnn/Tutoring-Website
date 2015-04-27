<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');
// Session Variables //
if(isset($_REQUEST['user']))
{
    $user       = $_REQUEST['user'];
    $pass       = $_REQUEST['password'];
    $first      = $_REQUEST['first'];
    $last       = $_REQUEST['last'];
    $major      = $_REQUEST['major'];
    $phone      = $_REQUEST['phone'];
    $email      = $_REQUEST['email'];
    $course     = $_REQUEST['course'];
    //$instruct   = $_REQUEST['instructor'];
    $tutor      = $_REQUEST['tutor'];
    //$angle      = $_REQUEST['angle'];
    $args       = $_REQUEST['args'];
    $albany     = $_REQUEST['albany'];
    $benton     = $_REQUEST['benton'];
    $lebanon    = $_REQUEST['lebanon'];
    $sweethome  = $_REQUEST['sweethome'];
    $agree      = $_REQUEST['agree'];

    addStudent($user, $pass, $first, $last, $major, $phone, $email, $course, $tutor, $args, $albany, $benton, $lebanon, $sweethome, $agree);
    login($user, $pass);
}

if(!isset($_SESSION['user']) || $_SESSION['user'] == 'none')
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}

if($_SESSION['access'] == 'basic')
{
    $data = getCourses();
	$courses = array();
	while($row = mysql_fetch_array($data))
	{
		$courses[$row['Id']] = $row;
	}
    $title = "Signup for Tutoring";
    $script = "../scripts/signup.js";
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
<form id="mainform" name="mainform" action="signup.php" method="post" onsubmit="return validateForm()">
    <div id="contents">
        <header>
            <h2>LBCC Learning Center</h2>
            <h2>Tutoring Program Registration</h2>
            <hr />
            <p>Please fill out form completely.</p>
        </header>
        <div id="signform">
            <div id="personal">
                <p>
                    First Name: <input type="text" name="first" id="first" required="required" />
                    Last Name: <input type="text" name="last" id="last" required="required" />
                    Student ID #: <input type="text" name="user" id="user" required="required" />
                </p>
                <p>
                    Password:<input type="password" name="password" id="password" required="required" />
                    Re-enter Password:  <input type="password" name="rePassword" id="rePassword" required="required" />
                </p>
                <p>
                    Phone Number: <input type="text" name="phone" id="phone" required="required" />
                    Email Address: <input type="email" name="email" id="email" required="required" />
                </p>
                <p>
                    Major: <input type="text" width="500px" name="major" id="major" required="required" />
                </p>
            </div>
            <div class="course">
                <p>Course Name:
                    <select name="course[]" id="course">
                        <option value=''></option>
                    <?php
                        foreach($courses as $key=>$value)
                        {
                            echo("<option value='$key'>$value</option>");
                        }
                    ?>
                    </select>
                    Instructor Name:<input type="text" name="instructor[]" id="instructor" />
                </p>
                <p class="third">Tutoring service to be used:<br />(please check one or both)</p>
                <p class="third"><input type="checkbox" name="tutor[]" id="tutor" />One-on-One Tutoring</p>
                <p class="third"><!-- <input type="checkbox" name="angle[]" id="angle" />Math Angle<br />(math 20 through 95) --></p>
            </div>
            <div class="addCourse">
                <input type="button" name="addCourse" value="Add Course" id="addCourse" />
            </div>
            <div class="hidden" id="angleDiv">
                <p>Have you taken this <span class="underline">same</span> math class previously?
                    <input type="radio" name="taken" value="Yes" id="takenYes" /> Yes
                    <input type="radio" name="taken" value="No" id="takenNo" default /> No
                </p>
                <div class="hidden" id="courseTaken">
                    <p>If yes, how many times have you attempted this same class <span class="underline">before</span> this term?</p>
                    <p>
                        <input type="radio" name="timesTaken" value="1" /> 1
                        <input type="radio" name="timesTaken" value="2" /> 2
                        <input type="radio" name="timesTaken" value="3" /> 3
                        <input type="radio" name="timesTaken" value="4" /> 4
                        <input type="radio" name="timesTaken" value="More than 4" /> More than 4
                    </p>
                    <p>If yes, which module(s) in the class gave you the most difficulty (if applicable)?</p>
                    <p>
                        <input type="checkbox" name="module[]" value="1" /> 1
                        <input type="checkbox" name="module[]" value="2" /> 2
                        <input type="checkbox" name="module[]" value="3" /> 3
                        <input type="checkbox" name="module[]" value="4" /> 4
                        <input type="checkbox" name="module[]" value="5" /> 5
                    </p>
                </div>
                <p>Select up to <span class="underline">four</span> reasons why you are struggling with math or have struggled with math in the past:</p>
                <div class="col">
                    <p><input type="checkbox" name="reasons[]" value="The class goes too fast for me" />The class goes too fast for me</p>
                    <p><input type="checkbox" name="reasons[]" value="I don\'t have a good place to study" /> I don't have a good place to study</p>
                    <p><input type="checkbox" name="reasons[]" value="I don\'t understand the text" /> I don't understand the text</p>
                    <p><input type="checkbox" name="reasons[]" value="I\'m unorganized" /> I'm unorganized</p>
                    <p><input type="checkbox" name="reasons[]" value="I have test anxiety" /> I have test anxiety</p>
                    <p><input type="checkbox" name="reasons[]" value="I\'ve missed a lot of class" /> I've missed a lot of class</p>
                    <p><input type="checkbox" name="reasons[]" value="I make a lot of little mistakes" /> I make a lot of little mistakes</p>
                </div>
                <div class="col">
                    <p><input type="checkbox" name="reasons[]" value="I don\'t have enough time to study" /> I don't have enough time to study</p>
                    <p><input type="checkbox" name="reasons[]" value="I don\'t have any study partners" /> I don't have any study partners</p>
                    <p><input type="checkbox" name="reasons[]" value="I don\'t understand the instructor" /> I don't understand the instructor</p>
                    <p><input type="checkbox" name="reasons[]" value="I can\'t stay focused or take good notes" /> I can't stay focused or take good notes</p>
                    <p><input type="checkbox" name="reasons[]" value="I forget everything right after I learn it" /> I forget everything right after I learn it</p>
                    <p><input type="checkbox" name="reasons[]" value="I get behind and can\'t catch up" /> I get behind and can't catch up</p>
                    <p><input type="checkbox" name="reasons[]" value="Other" /> Other: <input type="text" name="other" id="other" /></p>
                </div>
                <p class="clear">What are some strategies that you've tried before that have helped you be successful or what are some strategies that you think might help you?</p>
                <textarea name="strategies" id="strategies" cols="75" rows="15"></textarea>
                <p>What else should we know about how you learn in order to help you be successful?</p>
                <textarea name="learn"  id="learn" cols="75" rows="15"></textarea>
                <h4>Math Angle Reminders:</h4>
                <p>If the Math Angle is busy, please limit yourself to a maximum of <span class="underline">2 hours</span> per day.</p>
                <p>Have your homework, textbook, and notes ready <span class="underline">before</span> you put up your hand.</p>
                <p>If you wish to talk with friends or on your cell phone, please leave the Math Angle.</p>
            </div>
            <p>If you are a student registered with the Office of Disability Services, please submit a copy of your accommodations plan to <?php echo($_SESSION['adminFirst']." ".$_SESSION['adminLast']); ?>, Tutoring Program Coordinator, in <?php echo($_SESSION['adminOffice']); ?> before your first tutor appointment.</p>
            <div id="agreement">
                <h4>Registration Agreement. Please read and initial each item below:</h4>
                <div><input type="text" name="args[]" id="arg1" /><p>I agree to attend class, and that I will not schedule tutoring appointments during class.</p></div>
                <div><input type="text" name="args[]" id="arg2" /><p>I understand that the Tutoring Program Coordinator will notify my instructor in order to varify my class attendance.</p></div>
                <div><input type="text" name="args[]" id="arg3" /><p>I agree to arrive on time.</p></div>
                <div><input type="text" name="args[]" id="arg4" /><p>I understand that if I am more then 5 minutes late, that my appointment may be filled by the Tutor Coordinator.</p></div>
                <div><input type="text" name="args[]" id="arg5" /><p>I agree to cancel my tutoring appointments at least 2 hours in advance. Failure to show up for a tutoring appointment without canceling is a <strong>no-show</strong>. I understand that after <strong>one no-show</strong>, I will lose my tutoring eligibility for <strong>TWO WEEKS</strong>.</p></div>
                <div><input type="text" name="args[]" id="arg6" /><p>I agree to bring my textbook and course materials to each tutoring session, and to let my tutor know how to help me most effectively</p></div>
                <div><input type="text" name="args[]" id="arg7" /><p>I understand that some tutoring sessions may need to be shared with a small group.</p></div>
            </div>
            <div><p>Please check your 1st and 2nd choice of tutoring locations. We will strive to meet your request, but the actual tutoring location will depend on tutor availability</p></div>
            <div id="place">
                <p><input type="text" name="albany" id="albany" /> Albany</p>
                <p><input type="text" name="benton" id="benton" /> Benton Center</p>
                <p><input type="text" name="lebanon" id="lebanon" /> Lebanon Center</p>
                <p><input type="text" name="sweethome" id="sweethome" /> Sweet Home</p>
            </div>
            <div id="agree">
                <p><input type="checkbox" name="agree" id="agree" />Agree to all terms and conditions stated above. Checking this checkbox is the same as a signiture.</p>
            </div>
            <div id="buttons"><input type="reset" value="Reset" /><input type="submit" id="submit" value="Submit" /></div>
        </div>
    </div>
</form>
<?php
    include_once('../include/footer.php');
} else {
    header("location: /tutoring/mockup/welcome.php");
}
?>