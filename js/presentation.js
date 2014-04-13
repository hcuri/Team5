function createPresentation(pForm) {

	var title = pForm.title.value;
	var sessionName = pForm.session.value;
	var private = pForm.private.value;
	var groupName = $("#group :selected").text(); //the text content of the selected option
	var groupName2 = $("#group").val();

	alert(title + " " + sessionName + " " + " " + private + " " + groupName + " " + groupName2 + " ");

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