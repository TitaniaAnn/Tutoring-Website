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

if($_SESSION['tutoring'] == 1 && isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
	unset($_REQUEST['id']);
	$currentDay = date('w');
	$term 	= getTerms();
	foreach($term as $value) {
		$term = $value;
		break;
	}
	$tutor			= getUserName($id);
	$appointments 	= getTutorAppointments($id);
	$permWeek 		= getPermCalendar($id, $term['Id']);
	$tempWeek       = getTempCalendar($id, $term['Id']);

echo('<div class="week">');
    echo('<header>');
        echo('<h4>'.$tutor['FirstName'].' '.$tutor['LastName'].'\'s Calendar</h4>');
    echo('</header>');
    echo('<div class="day">');
        echo('<div class="time bord"></div>');
	foreach($time as $value) {
		echo('<div class="time bord">'.$value.'</div>');
	}
    echo('</div>');
foreach($day as $dkey => $dvalue) {
    echo("<div class='day ".$dvalue."'>");
        echo("<div class='time bord'>".$dvalue."</div>");
		$only = '';
		if(currentDay >= $dkey) {
			$only = 'readonly';
		}
        foreach($time as $key => $value) {
			$appoint	= null;
			$temp		= null;
            $perm 		= null;
			if($appointments != false) {
                foreach($appointments as $avalue) {
                    if($avalue['Time'] == $value && $avalue['Day'] == $dvalue && $avalue['Canceled'] != '1') {
                        $appoint = $avalue;
						break;
                    }
                }
            }
			if($tempWeek != false && $appoint == null) {
                foreach($tempWeek as $tvalue) {
                    if($tvalue['Time'] == $value && $tvalue['Day'] == $dvalue && $tvalue['Approve'] == '1') {
                        $temp = $tvalue;
						break;
                    }
                }
            }
			if($permWeek != false && $appoint == null && $temp == null) {
                foreach($permWeek as $pvalue) {
                    if($pvalue['Time'] == $value && $pvalue['Day'] == $dvalue && $pvalue['Available'] == '1' && $pvalue['Approve'] == '1') {
                        $perm = $pvalue;
						break;
                    }
                }
            }
			if($appoint != null) {
				if($appoint['StudentId'] == $_SESSION['userId']) {
					echo('<div class="time appointment taken yours '.$value.' '.$only.'">');
					echo('<ul>');
					echo('<li class="subtime">'.$value.'</li>');
					echo('<li class="availability">Yours - '.$appoint['Location'].'</li>');
				} else {
					echo('<div class="time appointment taken '.$value.' '.$only.'">');
					echo('<ul>');
					echo('<li class="subtime">'.$value.'</li>');
					echo('<li class="availability">Taken</li>');
				}
				echo('</ul>');
				echo('</div>');
			} else if($temp != null) {
				if($temp['Available'] == '1') {
					echo('<div class="time appointment open '.$value.' '.$only.'">');
					echo('<ul>');
					echo('<li class="subtime">'.$value.'</li>');
					echo('<li class="availability">Available - '.$temp['Location'].'</li>');
				} else {
					echo('<div class="time appointment not '.$value.' '.$only.'">');
					echo('<ul>');
					echo('<li class="subtime">'.$value.'</li>');
					echo('<li class="availability">un-Available</li>');
				}
				echo('</ul>');
				echo('</div>');
			} else if($perm != null) {
				echo('<div class="time appointment open '.$value.' '.$only.'">');
				echo('<ul>');
				echo('<li class="subtime">'.$value.'</li>');
				echo('<li class="availability">Available - '.$perm['Location'].'</li>');
				echo('</ul>');
				echo('</div>');
			} else {
				echo('<div class="time appointment not '.$value.' '.$only.'">');
				echo('<ul>');
				echo('<li class="subtime">'.$value.'</li>');
				echo('<li class="availability">un-Available</li>');
				echo('</ul>');
				echo('</div>');
			}
		}
	echo('</div>');
}                
echo('</div>');
if(date('w') > 2 && date('G') > 16) {
	$appointmentN    = getNextAppointments($id);
	$tempN           = getNextTempCalendar($id, $term['Id']);
	
echo('<div class="week">');
    echo('<header>');
        echo('<h4>'.$tutor['FirstName'].' '.$tutor['LastName'].'\'s Next Week\'s Calendar</h4>');
    echo('</header>');
    echo('<div class="day">');
        echo('<div class="time bord"></div>');
		foreach($time as $value) {
			echo('<div class="time bord">'.$value.'</div>');
		}
    echo('</div>');
	foreach($day as $dkey => $dvalue) {
		echo("<div class='day ".$dvalue."'>");
			echo("<div class='time bord'>".$dvalue."</div>");
			foreach($time as $key => $value) {
				$appoint	= null;
				$temp		= null;
				$perm 		= null;
				if($appointmentN != false) {
					foreach($appointmentN as $avalue) {
						if($avalue['Time'] == $value && $avalue['Day'] == $dvalue && $avalue['Canceled'] != '1') {
							$appoint = $avalue;
							break;
						}
					}
				}
				if($tempN != false && $appoint == null) {
					foreach($tempN as $tvalue) {
						if($tvalue['Time'] == $value && $tvalue['Day'] == $dvalue && $tvalue['Approve'] == '1') {
							$temp = $tvalue;
							break;
						}
					}
				}
				if($permWeek != false && $appoint == null && $temp == null) {
					foreach($permWeek as $pvalue) {
						if($pvalue['Time'] == $value && $pvalue['Day'] == $dvalue && $pvalue['Available'] == '1' && $pvalue['Approve'] == '1') {
							$perm = $pvalue;
							break;
						}
					}
				}
				if($appoint != null) {
					if($appoint['StudentId'] == $_SESSION['userId']) {
						echo('<div class="time next appointment taken yours '.$value.'">');
						echo('<ul>');
						echo('<li class="subtime">'.$value.'</li>');
						echo('<li class="availability">Yours - '.$appoint['Location'].'</li>');
					} else {
						echo('<div class="time next appointment taken '.$value.'">');
						echo('<ul>');
						echo('<li class="subtime">'.$value.'</li>');
						echo('<li class="availability">Taken</li>');
					}
					echo('</ul>');
					echo('</div>');
				} else if($temp != null) {
					if($temp['Available'] == '1') {
						echo('<div class="time next appointment open '.$value.'">');
						echo('<ul>');
						echo('<li class="subtime">'.$value.'</li>');
						echo('<li class="availability">Available - '.$temp['Location'].'</li>');
					} else {
						echo('<div class="time next appointment not '.$value.'">');
						echo('<ul>');
						echo('<li class="subtime">'.$value.'</li>');
						echo('<li class="availability">un-Available</li>');
					}
					echo('</ul>');
					echo('</div>');
				} else if($perm != null) {
					echo('<div class="time next appointment open '.$value.'">');
					echo('<ul>');
					echo('<li class="subtime">'.$value.'</li>');
					echo('<li class="availability">Available - '.$perm['Location'].'</li>');
					echo('</ul>');
					echo('</div>');
				} else {
					echo('<div class="time next appointment not '.$value.'">');
					echo('<ul>');
					echo('<li class="subtime">'.$value.'</li>');
					echo('<li class="availability">un-Available</li>');
					echo('</ul>');
					echo('</div>');
				}
			}
		echo('</div>');
	}                 
echo('</div>');
}
}
?>