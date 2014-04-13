// JavaScript Document

var root_url = "http://localhost/api/index.php/";

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
	
	$("#userEmail").html(email);
	var organization = info.organization;
	$("#org").attr("placeholder", organization);
	var orgID = info.schoolID;
	$("#orgID").attr("placeholder", orgID);
	
    if($("#logout").length === 1) {
		$("#logoLink").attr("href", "user.php");
	}
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
	var fName;
	var lName;
	var email;
	var organization;
	var schoolID;
	
	if($("#fName").val() === "") {
		fName = $("#fName").attr("placeholder");
	} else {
		fName = $("#fName").val();
	}
	if($("#lName").val() === "") {
		lName = $("#lName").attr("placeholder");
	} else {
		lName = $("#lName").val();
	}
	if($("#email").val() === "") {
		email = $("#email").attr("placeholder");
	} else {
		email = $("#email").val();
	}
	if($("#org").val() === "") {
		organization = $("#org").attr("placeholder");
	} else {
		organization = $("#org").val();
	}
	if($("#orgID").val() === "") {
		schoolID = $("#orgID").attr("placeholder");
	} else {
		schoolID = $("#orgID").val();
	}
	
	
	
	return JSON.stringify({
		"username": $("#userName").html(),
		"fName": fName,
		"lName": lName,
		"email": email,
		"organization": organization,
		"schoolID": schoolID
	});
}


