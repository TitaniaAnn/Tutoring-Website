        <div id="navigation" <?php if($_SESSION['access'] != "basic") { ?>class="logged" <?php } ?>>
            <ul id="nav" <?php if($_SESSION['access'] != "basic") { ?>class="loggedin" <?php } ?>>
                <li><a href="/tutoring/mockup/home.php?<?php echo htmlspecialchars(SID); ?>">Home</a><!--</li>-->
                <!--<li>--><a href="/tutoring/mockup/tutorInfo.php?<?php echo htmlspecialchars(SID); ?>">Tutoring Info</a><!--</li>-->
                <!--<li>--><a href="/tutoring/mockup/meetTutor.php?<?php echo htmlspecialchars(SID); ?>">Meet the Tutors</a><!--</li>-->
                <!--<li>--><a href="/tutoring/mockup/becomeTutor.php?<?php echo htmlspecialchars(SID); ?>">Become a Tutor</a><!--</li>-->
        <?php
            if($_SESSION['access'] == "basic")
            {
                ?>
                <!--<li>--><a href="/tutoring/mockup/security/signup.php?<?php echo htmlspecialchars(SID); ?>">SignUp</a><!--</li>-->
                <!--<li>--><a href="/tutoring/mockup/security/login.php?<?php echo htmlspecialchars(SID); ?>">Login</a></li>
                <?php
            }
            if($_SESSION['access'] != "basic")
            {
                ?>
                <!--<li>--><a href="/tutoring/mockup/security/logout.php?<?php echo htmlspecialchars(SID); ?>" onclick="return confirm('Are you sure you want to Logout?')">Logout</a></li>
            </ul>
            <ul id="log">
                <li><a href="/tutoring/mockup/welcome.php?<?php echo htmlspecialchars(SID); ?>">Welcome</a><!--</li>-->
                <?php
            }
            if(($_SESSION['access'] == "student" && $_SESSION['tutoring'] == true) || ($_SESSION['access'] == "tutor" && $_SESSION['tutoring'] == true))
            {
                ?>
                <!--<li>--><a href="/tutoring/mockup/student/calendars.php?<?php echo htmlspecialchars(SID); ?>">Tutor's Calendars</a><!--</li>-->
                <?php
            }
            if($_SESSION['access'] == "tutor")
            {
                ?>
                <!--<li>--><a href="/tutoring/mockup/tutor/appointments.php?<?php echo htmlspecialchars(SID); ?>">Appointments</a><!--</li>-->
                <!--<li>--><a href="/tutoring/mockup/tutor/calendar.php?<?php echo htmlspecialchars(SID); ?>">Your Calendar</a><!--</li>-->
                <?php
            }
            if($_SESSION['desk'])
            {
                ?>
                <!--<li>--><a href="/tutoring/mockup/desk/appointments.php?<?php echo htmlspecialchars(SID); ?>">Daily Schedule</a><!--</li>-->
                <!--<li>--><a href="/tutoring/mockup/desk/stats.php?<?php echo htmlspecialchars(SID); ?>">Stats</a><!--</li>-->
                <!--<li>--><a href="/tutoring/mockup/desk/courses.php?<?php echo htmlspecialchars(SID); ?>">Courses</a><!--</li>-->
                <?php
            }
            if($_SESSION['access'] == "admin")
            {
                ?>
                <!--<li>--><a href="/tutoring/mockup/admin/students.php?<?php echo htmlspecialchars(SID); ?>">Users</a><!--</li>-->
                <!--<li>--><a href="/tutoring/mockup/admin/tutors.php?<?php echo htmlspecialchars(SID); ?>">Tutors</a><!--</li>-->
                <!--<li>--><a href="/tutoring/mockup/admin/jobs.php?<?php echo htmlspecialchars(SID); ?>">Jobs</a><!--</li>-->
                <?php
            }
            if($_SESSION['access'] != "basic")
            {
                ?>
                <!--<li>--><a href="/tutoring/mockup/include/profile.php?<?php echo htmlspecialchars(SID); ?>">Profile</a></li>
                <?php
            }
        ?>
            </ul>
        </div>
    </div>