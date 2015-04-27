<?php
session_start();
include_once('../scripts/config.php');
include_once('../scripts/functions.php');

// Session Variables //
if(!isset($_SESSION['user']))
{
    $_SESSION['user'] = 'none';
    $_SESSION['access'] = 'basic';
    $_SESSION['tutoring'] = 0;
    $_SESSION['desk'] = false;
    $_SESSION['edit'] = false;
}

if($_SESSION['access'] == 'tutor') {
    $title  	= "Tutor's Calendar";
	$style		= "../styles/calendar.css";
    $script 	= "../scripts/calendar.js";

    $time   	= array("08:00AM", "08:30AM", "09:00AM", "09:30AM", "10:00AM", "10:30AM",
                    	"11:00AM", "11:30AM", "12:00AM", "12:30AM", "01:00PM", "01:30PM",
                    	"02:00PM", "02:30PM", "03:00PM", "03:30PM", "04:00PM", "04:30PM");
	$terms 		= getTerms();
	$term = reset($terms);
    $permWeek   = getPermCalendar($_SESSION['userId'], $term['Id']);
    $tempWeek   = getTempCalendar($_SESSION['userId'], $term['Id']);
	
    include_once('../include/header.php');
    include_once('../include/navigation.php');
?>

    <div id="contents">
        <h2>Your Calendar</h2>
        <p><select id="term" onChange="changeCalendarTerm(this.value)">
				<?php
                    foreach($terms as $t) {
                        echo('<option value="'.$t['Id'].'">'.$t['Term'].'</option>');
                    }
                ?>
            </select></p>
        <div class="tutorcalendar">
            <div class="calendar update">
                <div class="week">
                    <header>
                    	<h4>Update Weekly Calendar</h4>
                    </header>
                    <div class="day">
                        <div class='time bord'></div>
                    <?php
                        foreach($time as $value)
                        {
                            ?>
                            <div class='time bord'><?php echo($value); ?></div>
                            <?php
                        }
                    ?>
                    </div>
                    <div class='day Monday'>
                        <div class='time bord'>Monday</div>
                    <?php
                        foreach($time as $key => $value) {
                            $perm = null;
                            if($permWeek != false) {
                                foreach($permWeek as $pkey => $pvalue) {
                                    if($pvalue['Time'] == $value && $pvalue['Day'] == 'Monday') {
                                        $perm = $pvalue;
                                    }
                                }
                            }
                            if($perm != null && ($perm['Available'] == '1' || $perm['NewAvailable'] == '1') && $perm['NewAvailable'] != '0') {
								if($perm['Approve'] == '1' && $perm['ApproveDate'] > $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['Location'].'</li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php } else if($perm['Approve'] == '1' && $perm['ApproveDate'] < $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['NewLocation']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability waiting">Available - '.$perm['NewLocation'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
								<?php } else { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability waiting">Available - '.$perm['Location'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php }
                            } else {
                                ?>
                                <div class="time appointment not <?php echo($value); ?>">
                                    <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>'); ?>
                                        <li class="availability">un-Available</li>
                                        <li class="waiting"></li>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    </div>
                    <div class='day Tuesday'>
                        <div class='time bord'>Tuesday</div>
                    <?php
                        foreach($time as $key => $value) {
                            $perm = null;
                            if($permWeek != false) {
                                foreach($permWeek as $pkey => $pvalue) {
                                    if($pvalue['Time'] == $value && $pvalue['Day'] == 'Tuesday') {
                                        $perm = $pvalue;
                                    }
                                }
                            }
                            if($perm != null && ($perm['Available'] == '1' || $perm['NewAvailable'] == '1') && $perm['NewAvailable'] != '0') {
								if($perm['Approve'] == '1' && $perm['ApproveDate'] > $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['Location'].'</li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php } else if($perm['Approve'] == '1' && $perm['ApproveDate'] < $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['NewLocation']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability waiting">Available - '.$perm['NewLocation'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
								<?php } else { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability waiting">Available - '.$perm['Location'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php }
                            } else {
                                ?>
                                <div class="time appointment not <?php echo($value); ?>">
                                    <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>'); ?>
                                        <li class="availability">un-Available</li>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    </div>
                    <div class='day Wednesday'>
                        <div class='time bord'>Wednesday</div>
                    <?php
                        foreach($time as $key => $value) {
                            $perm = null;
                            if($permWeek != false) {
                                foreach($permWeek as $pkey => $pvalue) {
                                    if($pvalue['Time'] == $value && $pvalue['Day'] == 'Wednesday') {
                                        $perm = $pvalue;
                                    }
                                }
                            }
                            if($perm != null && ($perm['Available'] == '1' || $perm['NewAvailable'] == '1') && $perm['NewAvailable'] != '0') {
								if($perm['Approve'] == '1' && $perm['ApproveDate'] > $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['Location'].'</li><li class="waiting"></li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php } else if($perm['Approve'] == '1' && $perm['ApproveDate'] < $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['NewLocation']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['NewLocation'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
								<?php } else { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['Location'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php }
                            } else {
                                ?>
                                <div class="time appointment not <?php echo($value); ?>">
                                    <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>'); ?>
                                        <li class="availability">un-Available</li>
                                        <li class="waiting"></li>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    </div>
                    <div class='day Thursday'>
                        <div class='time bord'>Thursday</div>
                    <?php
                        foreach($time as $key => $value) {
                            $perm = null;
                            if($permWeek != false) {
                                foreach($permWeek as $pkey => $pvalue) {
                                    if($pvalue['Time'] == $value && $pvalue['Day'] == 'Thursday') {
                                        $perm = $pvalue;
                                    }
                                }
                            }
                            if($perm != null && ($perm['Available'] == '1' || $perm['NewAvailable'] == '1') && $perm['NewAvailable'] != '0') {
								if($perm['Approve'] == '1' && $perm['ApproveDate'] > $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['Location'].'</li><li class="waiting"></li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php } else if($perm['Approve'] == '1' && $perm['ApproveDate'] < $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['NewLocation']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['NewLocation'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
								<?php } else { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['Location'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php }
                            } else {
                                ?>
                                <div class="time appointment not <?php echo($value); ?>">
                                    <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>'); ?>
                                        <li class="availability">un-Available</li>
                                        <li class="waiting"></li>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    </div>
                    <div class='day Friday'>
                        <div class='time bord'>Friday</div>
                    <?php
                        foreach($time as $key => $value) {
                            $perm = null;
                            if($permWeek != false) {
                                foreach($permWeek as $pkey => $pvalue) {
                                    if($pvalue['Time'] == $value && $pvalue['Day'] == 'Friday') {
                                        $perm = $pvalue;
                                    }
                                }
                            }
                            if($perm != null && ($perm['Available'] == '1' || $perm['NewAvailable'] == '1') && $perm['NewAvailable'] != '0') {
								if($perm['Approve'] == '1' && $perm['ApproveDate'] > $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['Location'].'</li><li class="waiting"></li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php } else if($perm['Approve'] == '1' && $perm['ApproveDate'] < $perm['Update']) { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['NewLocation']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['NewLocation'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
								<?php } else { ?>
                                    <div class="time appointment open <?php echo($value.' '.$perm['Location']); ?>">
                                        <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>');
                                            echo('<li class="availability">Available - '.$perm['Location'].'</li><li class="waiting">Waiting for Approval</li>');
                                        ?>
                                        </ul>
                                    </div>
                                <?php }
                            } else {
                                ?>
                                <div class="time appointment not <?php echo($value); ?>">
                                    <ul>
                                        <?php echo('<li class="subtime">'.$value.'</li>'); ?>
                                        <li class="availability">un-Available</li>
                                        <li class="waiting"></li>
                                    </ul>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    </div>
                </div>
                <div id="temp">
                	<ul>
					<?php if($tempWeek != false) {
                        foreach($tempWeek as $value) {
							$tab = "&nbsp;&nbsp;&nbsp;&nbsp;";
							if($value['Available'] == '1') { $aval = 'yes'; } else { $aval = 'no&nbsp;'; }
							if($value['Approve'] == '1') { $aprov = 'yes'; } else { $aprov = 'no&nbsp;'; }
							echo('<li>Date: '.$value['Date'].$tab.'Day: '.$value['Day'].$tab.'Time: '.$value['Time'].$tab.'Available: '.$aval.$tab.'Location: '.$value['Location'].' - Approved: '.$aprov.'</li>');
						}
                    } else { ?>
                        <li>No Temporary Avalability Schedualed</li>
                    <?php } ?>
                	</ul>
                </div>
                <div id="form">
                    <span class="dateInput">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Date:<input type="date" id="date" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Time:
                        <select id="time">
                            <option value=''></option>
                            <?php
                                foreach($time as $value)
                                {
                                    echo("<option value='$value'>$value</option>");
                                }
                            ?>
                        </select>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Location:
                        <select id="locat">
                            <option value=''></option>
                            <option value='Albany'>Albany</option>
                            <option value='Benton'>Benton</option>
                            <option value='Lebanon'>Lebanon</option>
                            <option value='SweetHome'>SweetHome</option>
                        </select>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Available:<input type="checkbox" id="avail" value="1" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="button" id="add" onClick="addCalendarTerm(<?php echo($_SESSION['userId']); ?>)">Add</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
<?php
    include_once('../include/footer.php');
} else {
    header ("location: /tutoring/mockup/security/login.php");
}
?>