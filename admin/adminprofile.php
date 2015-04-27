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
    $title = "Profile";

    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
    <div id="contents">
        <h2>Admin</h2>
        <a href="#" id="c">Update Info</a>
        <hr />
        <div id="currentInfo">
            <div class="subjects">
                <header><h4>Computer Science</h4></header>
                <div class="classes">
                    <ul>
                        <li>CS161 - Java I</li>
                        <li>CS162 - Java II</li>
                        <li>CS295 - ASP.NET</li>
                    </ul>
                </div>
            </div>
            <div id="about">
                <header><h4>About Me</h4></header>
                <p>I'm really good at helping people learn to code in any language.</p>
            </div>  
        </div>
        <div id="changeInfo">
            <div class="subjects">
                <header>Subject: <input type="text" value="Computer Science" /><button type="button" id="addSubject">Add Subject</button></header>
                <div class="classes">
                    <ul>
                        <li>Classes: <button type="button" id="addClass">Add Class</button></li>
                        <li><input type="text" value="CS161 - Java I" /></li>
                        <li><input type="text" value="CS162 - Java II" /></li>
                        <li><input type="text" value="CS295 - ASP.NET" /></li>
                    </ul>
                </div>
            </div>
            <div id="about">
                <header><h4>About Me</h4></header>
                <textarea id="id" cols="45" rows="15">I'm really good at helping people learn to code in any language.</textarea>
            </div>
            <button type="button" id="submitInfo">Submit</button>
        </div>
    </div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/authentication/login.php");
}
?>