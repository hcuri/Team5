var root_url = "http://localhost/UPresent/api/index.php/";

//blah blah blah
$(document).ready(function(e) {
    if($("#logout").length === 1) {
		$("#logoLink").attr("href", "user.php");
	}
});

function checkLogin(lForm) {
	var username = lForm.logInUsername.value;
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
		window.location = "http://localhost/UPresent/index.php";
	}
	else {
		window.location = "http://localhost/UPresent/index.php";
	}
}

function checkRegister(pform) {
	var username = pform.signUpUsername.value;
	var email = pform.signUpEmail.value;
	var pwd = pform.signUpPassword.value;
	var pwdC = pform.signUpPasswordC.value
	
	if(pwd!==pwdC) {
		alert("Password and Confirm Password Do Not Match");
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
