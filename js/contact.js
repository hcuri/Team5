function register(rform) {
	$.ajax({
		type: 'POST',
		url: root_url + 'contact',
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