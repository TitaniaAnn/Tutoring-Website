$("#submit").click(function()
{
    $(".error").hide();
    var hasError    = false;
    var userVal     = $("#user").val();
    var passwordVal = $("#password").val();
    var checkVal    = $("#rePassword").val();
    var firstVal    = $("#first").val();
    var lastVal     = $("#last").val();
    var majorVal    = $("#major").val();
    var phoneVal    = $("#phone").val();
    var emailVal    = $("#email").val();
    var courseVal   = $("#course").val();
    var instructVal = $("#instructor").val();
    var tutorVal    = $("#tutor").val();
    //var angleVal    = $("#angle").val();
    var arg1Val     = $("#arg1").val();
    var arg2Val     = $("#arg2").val();
    var arg3Val     = $("#arg3").val();
    var arg4Val     = $("#arg4").val();
    var arg5Val     = $("#arg5").val();
    var arg6Val     = $("#arg6").val();
    var arg7Val     = $("#arg7").val();
    var agreeVal    = $("#agree").val();
	
	var arg1init    = ""+arg1Val.charAt(0)+arg1Val.substring(0, arg1Val.length - 1);
    var arg2init    = ""+arg2Val.charAt(0)+arg2Val.substring(0, arg2Val.length - 1);
    var arg3init    = ""+arg3Val.charAt(0)+arg3Val.substring(0, arg3Val.length - 1);
    var arg4init    = ""+arg4Val.charAt(0)+arg4Val.substring(0, arg4Val.length - 1);
    var arg5init    = ""+arg5Val.charAt(0)+arg5Val.substring(0, arg5Val.length - 1);
    var arg6init    = ""+arg6Val.charAt(0)+arg6Val.substring(0, arg6Val.length - 1);
    var arg7init    = ""+arg7Val.charAt(0)+arg7Val.substring(0, arg7Val.length - 1);

    var initVal     = ""+firstVal.charAt(0)+lastVal.charAt(0);
    
    var emailTest   = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var phoneTest   = /^\(?[2-9]\d{2}[\)\.-]?\s?\d{3}[\s\.-]?\d{4}$/;
    
    
    if(userVal == '')
    {
        alert("Please enter your X-number.");
        hasError = true;
    } else if(passwordVal == '')
    {
        alert("Please enter a password.");
        hasError = true;
    } else if(checkVal == '') {
        alert("Please re-enter your password.");
        hasError = true;
    } else if(passwordVal != checkVal) {
        alert("Passwords do not match.");
        hasError = true;
    } else if(firstVal == '') {
        alert("Pleast enter your first name.");
        hasError = true;
    } else if(lastVal == '') {
        alert("Please enter your last name.");
        hasError = true;
    } else if(majorVal == '') {
        alert("Please enter your major.");
        hasError = true;
    } else if(phoneVal == '') {
        alert("Please enter your phone number.");
        hasError = true;
    } else if(!phoneTest.test(phoneVal)) {
        alert("Please enter a valid phone number.");
        hasError = true;
    } else if(emailVal == '') {
        alert("Please enter your email.");
        hasError = true;
    } else if (!emailTest.test(emailVal)) {
        alert("Please enter a valid email.");
        hasError = true;
    }
	if(arg1Val == '' || arg1Val == null || arg2Val == '' || arg2Val == null || arg3Val == '' || arg3Val == null || arg4Val == '' || arg4Val == null || arg5Val == '' || arg5Val == null || arg6Val == '' || arg6Val == null || arg7Val == '' || arg7Val == null) {
		alert('Please initial all agreement boxes');
		hasError = true;
	} else if(arg1init != initVal || arg2init != initVal || arg3init != initVal || arg4init != initVal || arg5init != initVal || arg6init != initVal || arg7init != initVal) {
		alert('Please initial all agreement boxes');
		hasError = true;
	} else if(agreeVal == false) {
		alert('Please check the checkbox to represent your signiture');
		hasError = true;
	}
    if(hasError == true)
    {
        return false;
    }
});

/*$("#angle").toggle(function() {
    $("#angleDiv").removeClass("hidden");
    $("#angleDiv").show();
}, function() {
    $("#angleDiv").addClass("hidden");
    $("#angleDiv").hide();
});*/

$("#addCourse").click(function() {
							   
   $(".addCourse").before('<div class="course"><p>Course Name: <select name="course[]" id="course"><option value=""></option><?php foreach($courses as $key=>$value) { echo("<option value=\'$key\'>$value</option>"); } ?></select>Instructor Name:<input type="text" name="instructor[]" id="instructor" /></p><p class="third">Tutoring service to be used:<br />(please check one or both)</p><p class="third"><input type="checkbox" name="tutor[]" id="tutor" />One-on-One Tutoring</p><p class="third"><!-- <input type="checkbox" name="angle[]" id="angle" />Math Angle<br />(math 20 through 95) --></p></div>');
});
