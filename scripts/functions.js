// JavaScript Document
// Update Perm calendar				(calendar.php)
function updatePermCalendar(tutorId, term, day, time, location, available) {
	$.ajax({
		   type: "POST",
		   url: "../tutor/calUpdate.php",
		   data: "perm=true&tutorId="+tutorId+"&term="+term+"&day="+day+"&time="+time+"&location="+location+"&available="+available+"",
		   success: function() {
			   alert("Data saved");
		   },
		   error: function() {
			   alert("Error your calendar has not been updated");
		   }
	});
}
// Change calendar term				(calendar.php)
function addCalendarTerm(tutorId) {
	var term 		= $('#term').val();
	$('#term').val('');
	var date 		= $('#date').val();
	$('#date').val('');
	var time 		= $('#time').val();
	$('#time').val('');
	var location 	= $('#locat').val();
	$('#locat').val('');
	var available	= $('#avail').val();
	$('#avail').attr('checked', false);
	var d = new Date(date);
	var weekday=new Array(7);
		weekday[0]="Sunday";
		weekday[1]="Monday";
		weekday[2]="Tuesday";
		weekday[3]="Wednesday";
		weekday[4]="Thursday";
		weekday[5]="Friday";
		weekday[6]="Saturday";
	var day = weekday[d.getDay()]
	$.ajax({
		   type: "POST",
		   url: "../tutor/calUpdate.php",
		   data: "temp=true&tutorId="+tutorId+"&term="+term+"&date="+date+"&day="+day+"&time="+time+"&location="+location+"&available="+available+"",
		   success: function() {
			   alert("Data saved");
			   var a;
			   if(available == '1') { a = 'yes'; } else { a = 'no'; }
			   $('#temp ul').append('<li>Date: '+date+'&nbsp;&nbsp;&nbsp;&nbsp;Day: '+day+'&nbsp;&nbsp;&nbsp;&nbsp;Time: '+time+'&nbsp;&nbsp;&nbsp;&nbsp;Available: '+a+'&nbsp;&nbsp;&nbsp;&nbsp;Location: '+location+' - Approved: no</li>');
		   },
		   error: function() {
			   alert("Error your calendar has not been updated");
		   }
	});
}
// change the class that is selected for calender	(calendars.php)
function studentChangeCourse(id) {
	$('#tutor option').removeClass('hidden').addClass('hidden');
	$('#tutor option:first').removeClass('hidden');
	$('#tutor .'+id).removeClass('hidden');
}
// get tutor calender for student
function showTutorCalendar(tutorId) {
	if(tutorId != '') {
		$.ajax({
			  type: 'POST',
			  url: "../student/cal.php",
			  data: "id="+tutorId+"",
			  success: function(data) {
				 $('#calendar').html(data);
			  }
		});
	} else {
		$('#calendar').load("../student/calendars.php #calendar");
	}
}
