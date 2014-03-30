// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php/";

$(document).ready(function() {
    var info = $.ajax({
		type: 'GET',
		url: root_url + 'getUserInfo',
		dataType:"json",
		async:false,
	});
	info = info.responseJSON;
	
	var fName = info.fName;
	$("#fName").attr("placeholder", fName);
	var lName = info.lName;
	$("#lName").attr("placeholder", lName);
	var email = info.email;
	$("#email").attr("placeholder", email);
	var organization = info.organization;
	$("#org").attr("placeholder", organization);
	var orgID = info.schoolID;
	$("#orgID").attr("placeholder", orgID);
});