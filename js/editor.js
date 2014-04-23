var root_url = "http://localhost/UPresent/api/index.php/";
var resultCount = 0;
var fNames = new Array();
var lNames = new Array();
var usernames = new Array();



function getUsername(text) {
  var regExp = /\(([^)]+)\)/;
  var matches = regExp.exec(text);

  return matches[1];
}

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

  var left = (screen.width / 2) - ($("div#invContainer").width() / 2);
  var yee = left + "px";
  $("div#invContainer").css({left: yee});
  
  $("div#fadeout").hide();
  $("div#invContainer").hide();


  $("#inv").click(function(){
  	$("div#fadeout").show();
  	$("div#invContainer").show();
    $("div#fadeout").animate({opacity: 0.7}, "fast");
    $("div#invContainer").animate({opacity: 1.0}, "fast");
    getGroups();
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
  $('div#searchBar img#searchBtn').click(function() {
    alert("searching");
    var searchTxt = $('input#searchBox').val();

    if(searchTxt == "")
      flashErr(1, "Please fill out the search box");
    else if(searchTxt != "") {
      search(searchTxt);
    }
  });


  //Create group
  $("div#searchBar img#groupBtn").click(function() {
    alert("creating");
    var groupTxt = $('input#groupBox').val();

    if(groupTxt == "")
      flashErr(2, "Please fill out the group box");
    else if(groupTxt != "") {
      createGroup();
    }
  });
});





/*
AJAX CALLS TO API
*/
function addGroup(groupName) {
  var groupTable = $("div#groupTable").html();

  groupTable = groupTable + "<div id='gName'><img src='img/minusBtn.png' />" + groupName + "<input type='radio' name='groupNum' value='1'></div>";
  $("div#groupTable").html(groupTable);
}
function createGroup() {
    $.ajax({
    type: 'POST',
    url: root_url + 'createGroup',
    data: groupFormToJSON(),
    async: true,
    success: function(){
      addGroup($("input#groupBox").val());
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
    }
  });
}

function getGroups() {
  var groups = $.ajax({
    type: 'GET',
    url: root_url + 'getGroups',
    dataType: "json", // data type of response
    async: true,
    success: function() {
      if(count(groups.responseJSON) == 0)
        flashErr(1, "Nothing was returned");
      else {
        displayGroups(groups.responseJSON);
        //Selecting a group name
        $("div#gName").click(function() {
          if($(this).attr('class') === 'selected')
            $(this).css("background-color","#ffffff");
          else if($(this).attr('class') !== 'selected')
            $(this).css("background-color","#ededed");
          $(this).toggleClass('selected');
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert('Something went wrong\n search() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
    }
  });
}

function groupFormToJSON() {
  return JSON.stringify({
    "groupName": $('input#groupBox').val()
  });
}

function addUserToGroup(rowNum) {
  $.ajax({
      type: 'POST',
      url: root_url + 'addToGroup',
      data: addUserFormToJSON(rowNum),
      async: true,
      success: function(){
        getGroups();
      },
      error: function(jqXHR, textStatus, errorThrown){
        alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
      }
  });
}

function addUserFormToJSON(rowNum) {
  return JSON.stringify({
    "groupName": $("input[name=groupNum]:checked").parent().text(),
    "username": usernames[rowNum - 2] //not sure how this will be passed yet
  });
}

function deleteUserFromGroup(elem) {
    $.ajax({
    type: 'POST',
    url: root_url + 'deleteFromGroup',
    data: delUserFormToJSON(elem),
    async: true,
    success: function() {
      alert("yoyoyo");
      getGroups();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
    }
  });
}

function delUserFormToJSON(elem) {
  var username = $(elem).parent().text();
  var ind = $(elem).parent().index();
  var groupName;

  for(var i = ind; i >= 0; i--) {
    if($(elem).parent().parent().children(":eq(" + i + ")").attr('id') === 'gName') {
      groupName = $(elem).parent().parent().children(":eq(" + i + ")").text();
      break;
    }
  }

  return JSON.stringify({
    "groupName": groupName,
    "username": getUsername(username) //not sure how this will be passed yet
  });
}

function deleteGroup(elem) {
    $.ajax({
    type: 'POST',
    url: root_url + 'deleteGroup',
    data: delGroupFormToJSON(elem),
    async: true,
    success: function(){
      alert('Group deleted successfully');
      getGroups();
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
    }
  });
}
function delGroupFormToJSON(elem) {
  var groupName = $(elem).parent().text();
  alert(JSON.stringify({ "groupName": groupName }));

  return JSON.stringify({
    "groupName": groupName
  });
}

function displayUsers(users) {
  //clear entries
  var entries = $("div#tableHolder table").children().children();
  for(var i = 1; i < resultCount + 1; i++) {
    var currEntry = entries.eq(i).children();
    for(var j = 0; j < 4; j++) {
      if(j===0) {
        currEntry.eq(j).html("");
      } else if(j===1) {
        currEntry.eq(j).html("");
      } else if(j===2){
        currEntry.eq(j).html("");
      } else {
        currEntry.eq(j).html("");
      }
    }
  }

  resultCount = count(users);
  //add entries
  fNames = [];
  lNames = [];
  usernames = [];
  entries = $("div#tableHolder table").children().children();
  for(var i = 1; i < resultCount + 1; i++) {
    var currEntry = entries.eq(i).children();
    for(var j = 0; j < 4; j++) {
      if(j===0) {
        currEntry.eq(j).html(users[i-1].fName);
        fNames[i- 1] = users[i - 1].fName;
      } else if(j===1) {
        currEntry.eq(j).html(users[i-1].lName);
        lNames[i- 1] = users[i - 1].lName;
      } else if(j===2) {
        currEntry.eq(j).html(users[i-1].username);
        usernames[i- 1] = users[i - 1].username;
      } else {
        currEntry.eq(j).html("<img src='img/plusBtn.png' id='addToGroup' />");
      }
    }
  }
}

function displayGroups(groups) {
  for(var i = 0; i < count(groups); i++) {
    var numUsers = groups[i].numUsers;
    var users = groups[i].users;
    var groupTable;

    if(i == 0)
      groupTable = "<div id='gName'><img src='img/minusBtn.png' />" + groups[i].groupName + "<input type='radio' name='groupNum' value='1'><img src='img/trash.png' id='groupTrash' /></div>";
    else
      groupTable = groupTable + "<div id='gName'><img src='img/minusBtn.png' />" + groups[i].groupName + "<input type='radio' name='groupNum' value='1'><img src='img/trash.png' id='groupTrash' /></div>";
    for(var j = 0; j < numUsers; j++) {
      groupTable = groupTable + "<div id='uName'>" + users[j].name + " (" + users[j].username + ") <img src='img/trash.png' id='userTrash'/></div>";
    }
    $("div#groupTable").html(groupTable);
  }

  $("div#uName img").click(function() {
    deleteUserFromGroup(this);
  });
  $("div#gName img").click(function() {
    deleteGroup(this);
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
      if(count(users.responseJSON) == 0)
        flashErr(1, "Nothing was returned");
      else {
        displayUsers(users.responseJSON);
        $("img#addToGroup").click(function(event) {
          var td = event.target.parentNode.parentNode;
          var rowNum = $(td).attr('class');
          addUserToGroup(rowNum);
        });
      }
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
          else if(searchTxt != "") {
            search(searchTxt);
          }
        }
        else if($("input#groupBox").is(":focus")) { 
          var groupTxt = $('input#groupBox').val();

          if(groupTxt == "")
            flashErr(2, "Please fill out the group box");
          else if(groupTxt != "") {
            createGroup();
          }
        }
    }
});