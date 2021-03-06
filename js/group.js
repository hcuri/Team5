function count(obj) {
  var i = 0;
  for (var x in obj)
    if (obj.hasOwnProperty(x))
      i++;
  return i;
}

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

function search(searchTerm) {
	var term = searchTerm.replace(/ /g, '-');

	var users = $.ajax({
		type: 'GET',
		url: root_url + 'searchUsers/' + term,
		dataType: "json", // data type of response
		async: true,
		success: function() {
			return users.responseJSON;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert('Something went wrong\n search() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}
