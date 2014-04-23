var root_url = "http://localhost/UPresent/api/index.php/";

function count(obj) {
  var i = 0;
  for (var x in obj)
    if (obj.hasOwnProperty(x))
      i++;
  return i;
}

function flashErr(divNum, errMsg) {
  if(divNum == 1) {
    $('div#gErr').text("");
    $('div#uErr').css({opacity: 0.0});
    $('div#uErr').text(errMsg);
    $("div#uErr").animate({opacity: 1.0}, "slow", function(){
      $("div#uErr").animate({opacity: 0.0}, "slow");
    });
  }
  else if(divNum == 2) {
    $('div#uErr').text("");
    $('div#gErr').css({opacity: 0.0});
    $('div#gErr').text(errMsg);
    $("div#gErr").animate({opacity: 1.0}, "slow", function(){
      $("div#gErr").animate({opacity: 0.0}, "slow");
    });
  }
  else {
    alert("Internal error. You just broke the internet.");
  }
}

$(document).ready(function(){

  var left = (window.width / 2) - 250;
  $("div#invContainer").css({left: 350});
  
  $("div#fadeout").hide();
  $("div#invContainer").hide();


  $("#inv").click(function(){
  	$("div#fadeout").show();
  	$("div#invContainer").show();
    $("div#fadeout").animate({opacity: 0.7}, "fast");
    $("div#invContainer").animate({opacity: 1.0}, "fast");
  });
  $("div#fadeout").click(function(){
  	$("div#fadeout").animate({opacity: 0.0}, "fast", function(){
  		$("div#fadeout").hide();
  	});
  	$("div#invContainer").animate({opacity: 0.0}, "fast", function(){
  		$("div#invContainer").hide();
  	});
  });

  //groupTable

  //searching for users
  $('div#searchBar img').click(function() {
    var searchTxt = $('input#searchBox').val();

    if(searchTxt == "")
      flashErr(1, "Please fill out the search box");
    else if(searchTxt != "") {
      search(searchTxt);
    }
  });

  //Selecting a group name
  $("div#gName").click(function() {
      if($(this).attr('class') === 'selected')
        $(this).css("background-color","#ffffff");
      else if($(this).attr('class') !== 'selected')
        $(this).css("background-color","#ededed");
      $(this).toggleClass('selected');
  });

  //Create group
  $("div#searchBar img[src*='img/plusBtn.png']").click(function() {
    var groupTxt = $('input#groupBox').val();

    if(groupTxt == "")
      flashErr(2, "Please fill out the group box");
    else if(groupTxt != "") {
      alert(groupTxt);
    }
  });
  //Adding to group
  $("td.addToGroup img[src*='img/plusBtn.png']").click(function() {

  });
});





/*
AJAX CALLS TO API
*/
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

function displayUsers(users) {
  var entries = $("div#tableHolder table").children().children();
  for(var i = 1; i < count(users) + 1; i++) {
    var currEntry = entries.eq(i).children();
    for(var j = 0; j < 4; j++) {
      if(j===0) {
        currEntry.eq(j).html(users[i-1].fName);
      } else if(j===1) {
        currEntry.eq(j).html(users[i-1].lName);
      } else if(j===2){
        currEntry.eq(j).html(users[i-1].username);
      } else {
        currEntry.eq(j).html("<img src='img/plusBtn.png' />");
      }
    }
  }
}
function search(searchTerm) {
  var term = searchTerm.replace(/ /g, '-');

  var users = $.ajax({
    type: 'GET',
    url: root_url + 'searchUsers/' + term,
    dataType: "json", // data type of response
    async: true,
    success: function() {
      if(count(users.responseJSON) == 0)
        flashErr(1, "Nothing was returned");
      else
        displayUsers(users.responseJSON);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert('Something went wrong\n search() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
    }
  });
}

$(document).keypress(function(e) {
    if(e.which == 13) {
        if($("input#searchBox").is(":focus")) {
          var searchTxt = $('input#searchBox').val();

          if(searchTxt == "")
            flashErr(1, "Please fill out the search box");
          else if(searchTxt != "")
            search(searchTxt);
        }
        else if($("input#groupBox").is(":focus")) { 
          var groupName = $('input#groupBox').val();
        }
    }
});