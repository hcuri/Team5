if($.cookie('user') == null) {
    if(window.location.hostname + window.location.pathname !== root_root_root_url + "contact.php"){
        window.location = "index.php";
    }
}
$(document).ready(function(e) {
    if($("#logout").length === 1) {
		$("#logoLink").attr("href", "user.php");
	}
});

$('input[type=text], textarea').each(function(){
    var $this = $(this);
    $this.data('placeholder', $this.attr('placeholder'))
         .focus(function(){$this.removeAttr('placeholder');})
         .blur(function(){$this.attr('placeholder', $this.data('placeholder'));});
});

function checkLogin(lForm) {
        var usernameRegex = /^[a-zA-Z0-9\-]+$/;
	var username = lForm.logInUsername.value;
        var validUsername = username.match(usernameRegex);
        if (validUsername == null) {
            alert("The username you entered is not valid.");
            $("#logInUsername").focus();
            return false;
        }
	var pw = lForm.logInPassword.value;
	var check = $.ajax({
		type: 'GET',
		url: root_url + 'verify/' + username + '/' + pw,
		dataType: "json", // data type of response
		async: false,
	});
	check = check.responseJSON;
	check = check.registered;
	if(check === false){
		alert("Username and Password Do Not Match");
	}
	return check;
}


function logout() {
	var check = $.ajax({
		type: 'GET',
		url: root_url + 'logout',
		dataType: "json", // data type of response
		async: false,
		error: function(jqXHR, textStatus, errorThrown) {
			alert('Something went wrong\n logout() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
	check = check.responseJSON;
	check = check.loggedOut;
	if(check == true) {
		alert("Successfully logged out");
		window.location = root_root_url + "index.php";
	}
	else {
		window.location = root_root_url + "index.php";
	}
}

function checkRegister(pform) {
        var fNameRegex = /^[a-zA-Z\- ]+[^\s]$/;
        var lNameRegex = /^[a-zA-Z\-]+[^\s]$/;
        var usernameRegex = /^[a-zA-Z0-9\-]+$/;
        var validFName = pform.signUpFname.value.match(fNameRegex);
        var validLName = pform.signUpLname.value.match(lNameRegex);
        if (validFName == null) {
            alert("Your first name is not valid. Only characters A-Z, a-z, '-' and spaces are  acceptable. Also ensure your entry does not end with any whitespace.");
            $("#signUpFname").focus();
            return false;
        }
        if (validLName == null) {
            alert("Your last name is not valid. Only characters A-Z, a-z and '-' are  acceptable. Also ensure your entry does not end with any whitespace.");
            $("#signUpLname").focus();
            return false;
        }
        var username = pform.signUpUsername.value;
        var validUsername = username.match(usernameRegex);
        if (validUsername == null) {
            alert("Your username is not valid. Only characters A-Z, a-z, 0-9 and '-' are  acceptable.");
            $("#signUpUsername").focus();
            return false;
        }
	var email = pform.signUpEmail.value;
	var pwd = pform.signUpPassword.value;
	var pwdC = pform.signUpPasswordC.value
	
	if(pwd!==pwdC) {
		alert("Password and Confirm Password do not match");
		var obj = document.getElementById("signUpPassword");
		obj.value = obj.defaultValue;
		obj.focus();
		obj = document.getElementById("signUpPasswordC");
		obj.value = obj.defaultValue;
		return false;
	}
	else if(pwd.length < 8) {
		alert("Password must be at least 8 characters long");
		var obj = document.getElementById("signUpPassword");
		obj.value = obj.defaultValue;
		obj.focus();
		obj = document.getElementById("signUpPasswordC");
		obj.value = obj.defaultValue;
		return false;
	}
        else if(pwd.length > 16) {
            alert("Password can be at most 16 characters long");
            var obj = document.getElementById("signUpPassword");
            obj.value = obj.defaultValue;
            obj.focus();
            obj = document.getElementById("signUpPasswordC");
            obj.value = obj.defaultValue;
            return false;
        }

	var check = $.ajax({
		type: 'GET',
		url: root_url + 'registered/' + email + '/' + username,
		dataType: "json", // data type of response
		async: false,
		error: function(jqXHR, textStatus, errorThrown) {
			alert('Something went wrong\n checkRegistered() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
	check = check.responseJSON;

	var checkEmail = check.email;
	var checkUsername = check.username;
	var checkBool = true;
	if(checkEmail === true) {
		alert("Email is already registered");
		checkBool = false;
	}
	else if(checkUsername == true) {
		alert("Username is already registered");
		checkBool = false;
	}
	else if(checkBool == true) {
		register(pform);

	}
	return checkBool;
}

function register(rform) {
	$.ajax({
		type: 'POST',
		url: root_url + 'register',
		data: regFormToJSON(),
		async: false,
		success: function(){
			alert('User created successfully');
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}

// Helper function to serialize all the form fields into a JSON string
function regFormToJSON() {
	return JSON.stringify({
		"fName": $('#signUpFname').val(),
		"lName": $('#signUpLname').val(),
		"username": $('#signUpUsername').val(),
		"email": $('#signUpEmail').val(),
		"pass": $('#signUpPassword').val()
	});
}
