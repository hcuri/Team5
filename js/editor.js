var root_url = "http://localhost/UPresent/api/index.php/";
var resultCount = 0;
var fNames = new Array();
var lNames = new Array();
var usernames = new Array();
var linkedGroup = "";
var numSlides;
var currSlide;
var polls = new Array();



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
  if(i == 0)
    return 0;
  else
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

function getPresInfo() {
  $.ajax({
      type: 'GET',
      url: root_url + 'getPresInfo',
      async: true,
      dataType: "json",
      success: function(response) { 
        alert(JSON.stringify(response));
      },
      error: function(jqXHR, textStatus, errorThrown){
          alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
      }
  });
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
    if(linkedGroup === "")
      $("div#saveSubmit div").html("Presentation not linked to a group");
    else
      $("div#saveSubmit div").html("Presentation linked to " + linkedGroup);

  	$("div#fadeout").animate({opacity: 0.0}, "fast", function(){
  		$("div#fadeout").hide();
  	});
  	$("div#invContainer").animate({opacity: 0.0}, "fast", function(){
  		$("div#invContainer").hide();
  	});
  });
  
  $("#saveUPresent").click(function() {
      window.location = "user.php";
  });

  //groupTable

  //searching for users
  $('div#searchBar img#searchBtn').click(function() {
    var searchTxt = $('input#searchBox').val();

    if(searchTxt == "")
      flashErr(1, "Please fill out the search box");
    else if(searchTxt != "") {
      search(searchTxt);
    }
  });


  //Group Stuff
  getPresInfo();

  if(linkedGroup === "")
    $("div#saveSubmit div").html("Presentation not linked to a group");
  else
    $("div#saveSubmit div").html("Presentation linked to " + linkedGroup);


  $("div#searchBar img#plusBtn").click(function() {
    var groupTxt = $('input#groupBox').val();

    if(groupTxt == "")
      flashErr(1, "Please fill out the group box");
    else if(groupTxt != "") {
      createGroup();
    }
  });

  $("input#cancel").click(function() {
    $("div#saveSubmit div").html("Presentation linked to " + linkedGroup);

    $("div#fadeout").animate({opacity: 0.0}, "fast", function(){
      $("div#fadeout").hide();
    });
    $("div#invContainer").animate({opacity: 0.0}, "fast", function(){
      $("div#invContainer").hide();
    });
  });

  var checkedGroup = "";
  $("input#done").click(function() {
    checkedGroup = $("input[name=groupNum]:checked").parent().text();
    if(checkedGroup === "") {
      alert("Please select a group to link with your presentation.");
    }
    else {
      var r=confirm("Link presentation to [" + checkedGroup + "]?");
      if (r==true) {
        $("div#fadeout").animate({opacity: 0.0}, "fast", function(){
          $("div#fadeout").hide();
        });
        $("div#invContainer").animate({opacity: 0.0}, "fast", function(){
          $("div#invContainer").hide();
        });
        updatePresentation(checkedGroup);
      }
    }
  });

  //Photo Gallery
  $.ajax({
        type: 'GET',
        url: root_url + 'getSlides' + '/' + $.cookie('pres'),
        async: true,
        dataType: "json",
        success: function(response) { 
          numSlides = response.numSlides;

          //Add 'NONE' to each in polls array
          polls [0] = "NOT USED";
          for(var i = 1; i <= numSlides; i++) {
            polls[i] = "NONE";
          }

          addImages(response);
          var carousel = $("#carousel").featureCarousel({
            // include options like this:
            // (use quotes only for string values, and no trailing comma after last option)
            // option: value,
            // option: value
            autoPlay: 0
          });
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
        }
    });
    currSlide = 1;
    getPoll();
    $("div#carousel-left").click(function() {
      if(currSlide == 1)
        currSlide = numSlides;
      else
        currSlide--; 
      getPoll();
    });
    $("div#carousel-right").click(function() {
      if(currSlide == numSlides)
        currSlide = 1;
      else
        currSlide++;
      getPoll();
    });

    $()

    //Polling

    $("#pollSubmit").click(function() {
      addPoll();
    });

});

function addImages(json) {
  var num = json.numSlides;
  var slides = new Array();
  slides = json.slides;

  for(var i =1; i <= num; i++) {
    var insertImg = "<div class='carousel-feature'><a href='#'><img class='carousel-image' alt='Slide " + i + "'" 
                    + "src='" + slides[i] + "' /></a><div class='carousel-caption'>"
                    + "<p>Slide " + i + "</p></div></div>";
    //var insertImg = "<div class='carousel-feature'><a href='#'><img class='carousel-image' alt='Slide " + 
    //               i + "' src='" +  slides[i] + "'/></a><div class='carousel-caption'></div></div>";
    
    $("div#carousel").append(insertImg);
    var styles = {
      width: "450px",
      height: "230px"
    };
    $("div.carousel-feature img").css(styles);
  }
}




/*
AJAX CALLS TO API
*/

function updatePresentation(groupName) {
    $.ajax({
        type: 'POST',
        url: root_url + 'updatePresentation',
        data: updateToJSON(groupName),
        async: true,
        success: function(msg) {
            var response = JSON.parse(msg);
            var groupName = response.groupName;
            linkedGroup = groupName;
            $("div#saveSubmit div").html("Presentation linked to " + linkedGroup);
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
        }
    });
}

function updateToJSON(groupName) {
    return JSON.stringify({
        "groupName": groupName,
        "presName": $.cookie('presName')
    });
}
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
    success: function(response){
      if(response != 'group_exists')
        addGroup($("input#groupBox").val());
      else
        flashErr(2, "Group already exists");
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
        flashErr(1, "You have no groups");
      else
        displayGroups(groups.responseJSON);
        //alert(JSON.stringify(groups.responseJSON));
      
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
      success: function(response){
        if (response.indexOf("/*/") >= 0)
          flashErr(1, "User is already in that group");
        else {
          flashErr(2, "Adding user to group...");
          getGroups();
        }
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
  var groupTable;

  if(count(groups) == 0) {
    groupTable = "";
    $("div#groupTable").html(groupTable);
  }
  for(var i = 0; i < count(groups); i++) {
    var numUsers = groups[i].numUsers;
    var users = groups[i].users;

    if(i == 0)
      groupTable = "<div id='gName'><img src='img/minusBtn.png' />" + groups[i].groupName + "<input type='radio' name='groupNum' value='" + i + "'><img src='img/trash.png' id='groupTrash' /></div>";
    else
      groupTable = groupTable + "<div id='gName'><img src='img/minusBtn.png' />" + groups[i].groupName + "<input type='radio' name='groupNum' value='" + i + "'><img src='img/trash.png' id='groupTrash' /></div>";
    for(var j = 0; j < numUsers; j++) {
      groupTable = groupTable + "<div id='uName'>" + users[j].name + " (" + users[j].username + ") <img src='img/trash.png' id='userTrash'/></div>";
    }
    $("div#groupTable").html(groupTable);
  }

  $(":radio[value=0]").prop("checked", true)
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
          if(!$("input:radio[name=groupNum]").is(':checked')) {
            flashErr(1, "A group is not selected");
          }
          else {
            addUserToGroup(rowNum);
          }
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
            flashErr(2, "Searching...");
            search(searchTxt);
          }
        }
        else if($("input#groupBox").is(":focus")) { 
          var groupTxt = $('input#groupBox').val();

          if(groupTxt == "")
            flashErr(1, "Please fill out the group box");
          else if(groupTxt != "") {
            flashErr(2, "Creating group " + groupTxt + "...");
            createGroup();
          }
        }
    }

    //Photo Gallery 

    //Doesn't work
    if(e.which == 37) {
      alert("sup");
      console.log("left arrow");
      $("#carousel-left").trigger('click');
    } 
    if(e.which == 39) {
      alert("sup yo");
      console.log("right arrow");
      $("#carousel-right").trigger('click');
    }
});

//Polling
function addPoll() {
  $.ajax({
    type: 'POST',
    url: root_url + 'createPoll',
    data: pollFormToJSON(),
    async: true,
    success: function() {
      alert("yoyoyo ya poll be created");
    },
    error: function(jqXHR, textStatus, errorThrown){
      alert('Something went wrong\naddPoll() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
    }
  });
}
function pollFormToJSON() {
  //Set all vars for json
  var presId = $.cookie('pres');
  var numOptions = 0;
  var slideNum = currSlide;
  var question = $("input#PollQuestion").val();
  var opt1 = $("input#OptionA").val();
  var opt2 = $("input#OptionB").val();
  var opt3 = $("input#OptionC").val();
  var opt4 = $("input#OptionD").val();
  var opt5 = $("input#OptionE").val();
  var opt6 = $("input#OptionF").val();
  var showResults = $('input#1').prop('checked')

  //Set text vars and count options
  if(opt1 == '') opt1 = "NULL";
  else           numOptions++;
  if(opt2 == '') opt2 = "NULL";
  else           numOptions++;
  if(opt3 == '') opt3 = "NULL";
  else           numOptions++;
  if(opt4 == '') opt4 = "NULL";
  else           numOptions++;
  if(opt5 == '') opt5 = "NULL";
  else           numOptions++;
  if(opt6 == '') opt6 = "NULL";
  else           numOptions++;

  //set show results
  if($('input#showGraph').prop('checked')) 
      showResults = "true";
  else                                     
      showResults = "false";

  /*pollJSON = '[{"presId":"' + presId + '","numOptions":"' + numOptions + '", "question":"' + question + '", "slide":"' 
              + currSlide + '", "showResults":"' + showResults + '", "options":{ "A":"' + opt1 + '", "B":"' + opt2 + '", "C":"' + opt3 + '", "D":"' + opt4
              + '", "E":"' + opt5 + '", "F":"' + opt6 + '"}}]';*/

  return JSON.stringify({
    "presId": presId,
    "numOptions": numOptions,
    "question": question,
    "slide": currSlide,
    "showResults": showResults,
    "A": opt1,
    "B": opt2,
    "C": opt3,
    "D": opt4,
    "E": opt5,
    "F": opt6,
  });
}

function getPoll() {
  var slide = currSlide;
  $.ajax({
    type: 'GET',
    url: root_url + 'getPollInfo' + '/' + $.cookie('pres') + '/' + slide,
    dataType: "json", // data type of response
    async: true,
    success: function(response) {
      fillPoll(response);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      alert('Something went wrong\n getPoll() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
    }
  });
}

function fillPoll(json) {
    
  if("poll" in json) {
      document.getElementById('PollQuestion').value = '';
      document.getElementById('OptionA').value = '';
      document.getElementById('OptionB').value = '';
      document.getElementById('OptionC').value = '';
      document.getElementById('OptionD').value = '';
      document.getElementById('OptionE').value = '';
      document.getElementById('OptionF').value = '';
      document.getElementById('showGraph').checked = false;
  }
  var question = document.getElementById("PollQuestion");
  if("question" in json)
    question.value = json.question;
  
  var opA = document.getElementById("OptionA");
  if("A" in json.options)
    opA.value = json.options.A;
  
  var opB = document.getElementById("OptionB");
  if("B" in json.options)
    opB.value = json.options.B;
  
  var opC = document.getElementById("OptionC");
  if("C" in json.options)
    opC.value = json.options.C;
  
  var opD = document.getElementById("OptionD");
  if("D" in json.options)
    opD.value = json.options.D;
  
  var opE = document.getElementById("OptionE");
  if("E" in json.options)
    opE.value = json.options.E;
  
  var opF = document.getElementById("OptionF");
  if("F" in json.options)
    opF.value = json.options.F;

  var showGraph = document.getElementById("showGraph");
  if("showResults" in json) {
    if(json.showResults === 1)
      showGraph.checked = true;
  }
    
}