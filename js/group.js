var root_url = "http://localhost/UPresent/api/index.php/";

function createGroup(gform) {
    $.ajax({
		type: 'POST',
		url: root_url + 'createGroup',
		data: groupFormToJSON(),
		async: false,
		success: function(){
			alert('Group created successfully');
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}

function groupFormToJSON() {
	return JSON.stringify({
		"fName": $('#signUpFname').val(),
		"lName": $('#signUpLname').val(),
		"username": $('#signUpUsername').val(),
		"email": $('#signUpEmail').val(),
		"pass": $('#signUpPassword').val()
	});
}

