// student calendar need to update to ajax
/*$(".schedule div.appointment").click(function() {
    if($(this).hasClass("open"))
    {
        var a = Math.floor(Math.random()*11);
        if(a%2 == 0)
        {
            $(this).removeClass("open").addClass("yours");
        } else {
            $(this).removeClass("open").addClass("taken");
            alert("Sorry someone else signed up before you. Try another time!");
        }
    } else if($(this).hasClass("yours"))
    {
        $(this).removeClass("yours").addClass("open");
    }
});*/

// tutor calendar
$(".update div.appointment").click(function() {
	var tutorId = <?php echo($_SESSION['userId']); ?>;
	var term = $('#term').val();
    var time;
    var day;
    var classList;
    if($(this).hasClass("open") && $(this).hasClass("Albany")) {
        $(this).removeClass("Albany").addClass("Benton");
        $(this).find('.availability').text("Available - Benton");
		$(this).find('.waiting').text("Waiting for Approval");
        classList = $(this).attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'time' && item != 'appointment' && item != 'not' && item != 'open' && item != 'Albany' && item != 'Benton' && item != 'Lebanon' && item != 'SweetHome') {
               time = item;
            }
        });
        classList = $(this).parent().attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'day') {
               day = item;
            }
        });
		updatePermCalendar(tutorId, term, day, time, "Benton", 1);
    } else if($(this).hasClass("open") && $(this).hasClass("Benton")) {
        $(this).removeClass("Benton").addClass("Lebanon");
        $(this).find('.availability').text("Available - Lebanon");
		$(this).find('.waiting').text("Waiting for Approval");
        classList = $(this).attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'time' && item != 'appointment' && item != 'not' && item != 'open' && item != 'Albany' && item != 'Benton' && item != 'Lebanon' && item != 'SweetHome') {
               time = item;
            }
        });
        classList = $(this).parent().attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'day') {
               day = item;
            }
        });
		updatePermCalendar(tutorId, term, day, time, "Lebanon", 1);
    } else if($(this).hasClass("open") && $(this).hasClass("Lebanon")) {
        $(this).removeClass("Lebanon").addClass("SweetHome");
        $(this).find('.availability').text("Available - SweetHome");
		$(this).find('.waiting').text("Waiting for Approval");
        classList = $(this).attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'time' && item != 'appointment' && item != 'not' && item != 'open' && item != 'Albany' && item != 'Benton' && item != 'Lebanon' && item != 'SweetHome') {
               time = item;
            }
        });
        classList = $(this).parent().attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'day') {
               day = item;
            }
        });
		updatePermCalendar(tutorId, term, day, time, "SweetHome", 1);
    } else if($(this).hasClass("open") && $(this).hasClass("SweetHome")) {
        $(this).removeClass("SweetHome").removeClass("open").addClass("not");
        $(this).find('.availability').text("Un-Available");
		$(this).find('.waiting').text("Waiting for Approval");
        classList = $(this).attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'time' && item != 'appointment' && item != 'not' && item != 'open' && item != 'Albany' && item != 'Benton' && item != 'Lebanon' && item != 'SweetHome') {
               time = item;
            }
        });
        classList = $(this).parent().attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'day') {
               day = item;
            }
        });
		updatePermCalendar(tutorId, term, day, time, "none", 0);
    } else {
        $(this).removeClass("not").addClass("open").addClass("Albany");
        $(this).find('.availability').text("Available - Albany");
		$(this).find('.waiting').text("Waiting for Approval");
        classList = $(this).attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'time' && item != 'appointment' && item != 'not' && item != 'open' && item != 'Albany' && item != 'Benton' && item != 'Lebanon' && item != 'SweetHome') {
               time = item;
            }
        });
        classList = $(this).parent().attr('class').split(/\s+/);
        $.each( classList, function(index, item){
            if (item != 'day') {
               day = item;
            }
        });
		updatePermCalendar(tutorId, term, day, time, "Albany", 1);
    }
});

$("#current").click(function() {
    $(".update").hide();
	$("#term").hide();
    $(this).hide();
    $(".current").fadeIn("slow");
    $("#update").fadeIn("slow");
});
$("#update").click(function() {
    $(".current").hide();
    $(this).hide();
    $(".update").fadeIn("slow");
    $("#current").fadeIn("slow");
	$("#term").fadeIn("slow");
});
/*
$("#c").click(function() {
    $("#currentInfo").hide();
    $("#changeInfo").fadeIn();
});
$("#submitInfo").click(function() {
    $("#changeInfo").hide();
    $("#currentInfo").fadeIn();
});
*/