<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

$title  = "Tutor's Calendars";
$script = "../scripts/calender.js";

// Session Variables //
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['tutoring'] = 0;
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}

if(($_SESSION['access'] == 'user' && $_SESSION['tutoring'])|| ($_SESSION['access'] == 'tutor' && $_SESSION['tutoring']))
{
    $time   = array("08:00AM", "08:30AM", "09:00AM", "09:30AM", "10:00AM", "10:30AM",
                    "11:00AM", "11:30AM", "12:00AM", "12:30AM", "01:00PM", "01:30PM",
                    "02:00PM", "02:30PM", "03:00PM", "03:30PM", "04:00PM", "04:30PM");
    $week   = getCalender($_SESSION['userId']);
    $cweek   = getPermCalender($_SESSION['userId']);
    $tweek  = getTempCalender($_SESSION['userId']);
    
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>
    <div id="contents">
        <h2>Your Calender</h2>
        <p><button type="button" id="current">Current Schedule</button><button type="button" id="update">Update Schedule</button></p>
        <div class="tutorcalender">
            <div class="calender current">
                <div class="week">
                    <header><h4>Current Week</h4></header>
                    <div class="day">
                        <div class="time bord"></div>
                        <?php
                        foreach($time as $value)
                        {
                            ?>
                            <div class='time bord'><?php echo($value); ?></div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class='day monday'>
                        <div class='time bord'>Monday</div>
                        <?php
                        $count = 0;
                        foreach($week as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Monday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                    <div class='day tuesday'>
                        <div class='time bord'>Tuesday</div>
                        <?php
                        $count = 0;
                        foreach($week as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Tuesday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                    <div class='day wednesday'>
                        <div class='time bord'>Wednesday</div>
                        <?php
                        $count = 0;
                        foreach($week as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Wednesday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                    <div class='day thursday'>
                        <div class='time bord'>Thursday</div>
                        <?php
                        $count = 0;
                        foreach($week as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Thursday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                    <div class='day friday'>
                        <div class='time bord'>Friday</div>
                        <?php
                        $count = 0;
                        foreach($week as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Friday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="calender update">
                <div class="week">
                    <header><h4>Update Week</h4></header>
                    <div class="day">
                        <div class="time bord"></div>
                        <?php
                        foreach($time as $value)
                        {
                            ?>
                            <div class='time bord'><?php echo($value); ?></div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class='day monday'>
                        <div class='time bord'>Monday</div>
                        <?php
                        $count = 0;
                        foreach($cweek as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Monday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                    <div class='day tuesday'>
                        <div class='time bord'>Tuesday</div>
                        <?php
                        $count = 0;
                        foreach($cweek as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Tuesday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                    <div class='day wednesday'>
                        <div class='time bord'>Wednesday</div>
                        <?php
                        $count = 0;
                        foreach($cweek as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Wednesday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                    <div class='day thursday'>
                        <div class='time bord'>Thursday</div>
                        <?php
                        $count = 0;
                        foreach($cweek as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Thursday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                    <div class='day friday'>
                        <div class='time bord'>Friday</div>
                        <?php
                        $count = 0;
                        foreach($cweek as $key => $value)
                        {
                            if($value['Time'] == $times[$count] && $value['Day'] == 'Friday')
                            {
                                if($value['StudentId'] != '' || $value['StudentId'] != null)
                                {
                                    ?>
                                    <div class="time taken <?php echo($times[$count]); ?>">
                                        <?php echo($value['Time']); ?><br />
                                        <span class="Availability">Taken</span>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="time open <?php echo($times[$count]); ?>">
                                        <?php echo($value); ?><br />
                                        <span class="Availability">Available</span>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div class="time not <?php echo($times[$count]); ?>">
                                    <?php echo($value); ?><br />
                                    <span class="Availability">un-Available</span>
                                </div>
                                <?php
                            }
                            $count++;
                        }
                        ?>
                    </div>
                </div>
                <textarea name="comments" id="comments" cols="45" rows="15">
                </textarea>
                <button type="button" id="approvalT">Submit for approval</button>
            </div>
        </div>
    </div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/authentication/login.php");
}
?>