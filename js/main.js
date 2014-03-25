var root_url = "http://localhost/UPresent/api/index.php/";

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
		alert("Email and Password Do Not Match");
	}
	return check;
}



function checkRegister(pform) {
	var username = pform.signUpUsername.value;
	var email = pform.signUpEmail.value;
	var pwd = pform.signUpPassword.value;
	var pwdC = pform.signUpPasswordC.value
	if(pwd!==pwdC) {
		alert("Password and Confirm Password Do Not Match");
		document.getElementById("signUp").reset();
		return false;
	}
	var check = $.ajax({
		type: 'GET',
		url: root_url + 'registered/' + email,
		dataType: "json", // data type of response
		async: false,
	});
	check = check.responseJSON;
	check = check.email_registered;
	if(check === true) {
		alert("Email is already registered");
	}
	else {
		register(pform);
	}
	return !check;
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
			alert('register() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}

// Helper function to serialize all the form fields into a JSON string
function regFormToJSON() {
	return JSON.stringify({
		"fName": $('#signUpFname').val(),
		"lName": $('#signUpLname').val(),
		"email": $('#signUpEmail').val(),
		"pass": $('#signUpPassword').val()
	});
}