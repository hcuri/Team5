var root_url = "http://localhost/UPresent/api/index.php/";

function checkLogin(lForm) {
	var email = lForm.email.value;
	var pw = lForm.pwd.value;
	var check = $.ajax({
		type: 'GET',
		url: root_url + 'verify/' + email + '/' + pw,
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
	var username = pform.username.value;
	var email = pform.email.value;
	var pwd = pform.pwd.value;
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
		"username": $('#signUpUsername').val(), 
		"email": $('#signUpEmail').val(),
		"pass": $('#signUpPassword').val()
	});
}