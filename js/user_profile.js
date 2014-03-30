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
	
	var userN = info.username;
	$("#userName").html(userN);
	
	var fName = info.fName;
	$("#fName").attr("placeholder", fName);
	var lName = info.lName;
	$("#lName").attr("placeholder", lName);
	
	var fullName = fName + " " + lName;
	$("#fullName").html(fullName);
	
	var email = info.email;
	$("#email").attr("placeholder", email);
	
	$("#userEmail").html(email);
	var organization = info.organization;
	$("#org").attr("placeholder", organization);
	var orgID = info.schoolID;
	$("#orgID").attr("placeholder", orgID);
});

function updateProfile(pForm) {
	$.ajax({
		type:"POST",
		url:root_url + "postUserInfo",
		data:updateToJSON(),
		async:false,
		success: function() {
			alert("User Info Updated");
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert("Something went wrong...error: " + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}

function updateToJSON() {
	return JSON.stringify({
		"username": $("#userName").html(),
		"fName": $("#fName").val(),
		"lName": $("#lName").val(),
		"email": $("#email").val(),
		"organization": $("#org").val(),
		"schoolID": $("#orgID").val()
	});
}


