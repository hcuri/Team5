var root_url = "http://localhost/UPresent/api/index.php/";

function createGroup(gform) {
    $.ajax({
		type: 'POST',
		url: root_url + 'createGroup',
		data: groupFormToJSON(),
		async: true,
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
		"groupName": $('#groupName').val()
	});
}

function addUserToGroup(auform) {
    $.ajax({
		type: 'POST',
		url: root_url + 'addToGroup',
		data: addUserFormToJSON(),
		async: true,
		success: function(){
			alert('User added successfully');
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}

function addUserFormToJSON() {
	return JSON.stringify({
		"groupName": $.cookie('currentGroup'),
		"username": $('#username').val() //not sure how this will be passed yet
	});
}

function deleteUserToGroup(auform) {
    $.ajax({
		type: 'POST',
		url: root_url + 'deleteFromGroup',
		data: delUserFormToJSON(),
		async: true,
		success: function(){
			alert('User deleted successfully');
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}

function delUserFormToJSON() {
	return JSON.stringify({
		"groupName": $.cookie('currentGroup'),
		"username": $('#username').val() //not sure how this will be passed yet
	});
}

function deleteGroup(gform) {
    $.ajax({
		type: 'POST',
		url: root_url + 'deleteGroup',
		data: delGroupFormToJSON(),
		async: true,
		success: function(){
			alert('Group deleted successfully');
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}

function groupFormToJSON() {
	return JSON.stringify({
		"groupName": $.cookie('currentGroup')
	});
}

