// JavaScript Document

var presNames = new Array();
var presIDs = new Array();

var upPresNames = new Array();
var upPresAuthor = new Array();
var upPresDate = new Array();
var upPresIDs = new Array();
var pastPresNames = new Array();
var pastPresAuthor = new Array();
var pastPresDate = new Array();
var pastPresIDs = new Array();
var row;

$(document).ready(function() {
	$("#tabs1").tabs();
	$( "#tabs2" ).tabs();
	$("#newPres").click(function() {
		window.location = "http://localhost/new.php";
	});
	$(".trashIcon").click(function() {
		alert("Deleting UPresent");
	});
	
	var userN = $("#logoutUsername").html();
	
	var pres = $.ajax({
		type: 'GET',
		url: root_url + "getPresentations/" + userN,
		dataType: "json",
		async: false,
	});
	pres = pres.responseJSON;
	
	var numUPres = count(pres);
	
	for(var i = 0; i < numUPres; i++) {
		presNames.push(pres[i].presName);
		presIDs.push(pres[i].presId);	
	}
	
	
	//fill current table
	var entries = $("#current").children().children();
	for(var i = 0; i < numUPres; i++) {
		var currEntry = entries.eq(i).children();
		for(var j = 0; j < 4; j++) {
			if(j===0) {
				currEntry.eq(j).html(presNames[i]);
			} else if(j===1) {
				currEntry.eq(j).html("<input class=\"presentB\" type=\"button\" value=\"Present\">");
			} else if(j===2){
				currEntry.eq(j).html("<input class=\"editB\" type=\"button\" value=\"Edit\">");
			} else {
				currEntry.eq(j).html("<img class=\"trashIcon\" src=\"img/trash.png\">");
			}
		}
	}
	$(".presentB").click(function(event) {
		row = event.target.parentNode.parentNode;
		row = $(row).attr('class');
		presentUPresent(row);
	});
	
	$(".editB").click(function(event) {
		row = event.target.parentNode.parentNode;
		row = $(row).attr('class');
		editUPresent(row);
	});
	
	$(".trashIcon").click(function(event) {
		row = event.target.parentNode.parentNode;
		row = $(row).attr('class');
		
		$("#deleteName").html("Deleting: <b>" + presNames[row-1] + "</b>... Are You Sure?");
		$( "#dialog-confirm" ).dialog("open");
	});
	
	$( "#dialog-confirm" ).dialog({
      resizable: false,
	  autoOpen: false,
      height:200,
	  width:400,
      modal: true,
      buttons: {
        "Delete UPresent": function() {
          $( this ).dialog( "close" );
		  deleteUPresent(row);
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
	
	
	//UPCOMING TABLE DATA
	var pres = $.ajax({
		type: 'GET',
		url: root_url + "getUpcomingPresentations/" + userN,
		dataType: "json",
		async: false,
	});
	pres = pres.responseJSON;
	
	numUPres = count(pres);
	
	for(var i = 0; i < numUPres; i++) {
		upPresNames.push(pres[i].presName);
		upPresAuthor.push(pres[i].presName);
		upPresDate.push(pres[i].date);
		upPresIDs.push(pres[i].presId);	
	}
	
	
	//fill upcoming table
	var entries = $("#upcoming").children().children();
	for(var i = 0; i < entries.length; i++) {
		var currEntry = entries.eq(i).children();
		for(var j = 0; j < 4; j++) {
			if(j===0) {
				currEntry.eq(j).html(upPresNames[i]);
			} else if (j===1) {
				currEntry.eq(j).html(upPresAuthor[i]);
			} else if (j===2) {
				currEntry.eq(j).html(upPresDate[i]);
			} else {
				currEntry.eq(j).html("<input type=\"button\" class=\"viewUp\" value=\"View\">");
			}
		}
	}
	
	$(".viewUp").click(function(event) {
		row = event.target.parentNode.parentNode;
		row = $(row).attr('class');
		viewUPresent(row);
	});
	
	
	//PAST UPRESENTS TABLE DATA
	var pres = $.ajax({
		type: 'GET',
		url: root_url + "getPastPresentations/" + userN,
		dataType: "json",
		async: false,
	});
	pres = pres.responseJSON;
	
	numUPres = count(pres);
	
	for(var i = 0; i < numUPres; i++) {
		pastPresNames.push(pres[i].presName);
		pastPresAuthor.push(pres[i].presName);
		pastPresDate.push(pres[i].date);
		pastPresIDs.push(pres[i].presId);	
	}
	
	
	//fill past presentation table
	//BASE OFF THIS
	var entries = $("#past").children().children();
	for(var i = 1; i < entries.length+1; i++) {
		var currEntry = entries.eq(i).children();
		for(var j = 0; j < 4; j++) {
			if(j===0) {
				currEntry.eq(j).html(pastPresNames[i]);
			} else if (j===1) {
				currEntry.eq(j).html(pastPresAuthor[i]);
			} else if (j===2) {
				currEntry.eq(j).html(pastPresDate[i]);
			} else {
				currEntry.eq(j).html("<input type=\"button\" class=\"viewPast\" value=\"View\">");
			}
		}
	}
	
	$(".viewPast").click(function(event) {
		row = event.target.parentNode.parentNode;
		row = $(row).attr('class');
		viewPastUPresent(row);
	});
});

function count(obj) {
  var i = 0;
  for (var x in obj)
    if (obj.hasOwnProperty(x))
      i++;
  return i;
}

function presentUPresent(num) {
	//call ajax to delete presentation from the parameter
	alert("Presenting: " + presNames[num-1] + " : " +presIDs[num-1]);
	$.cookie('pres', presIDs[num-1]);
    window.location="presenter.php";
	return true;
}

function editUPresent(num) {
	//call ajax to delete presentation from the parameter
	alert("Editing: " + presNames[num-1]);
	$.cookie('pres', presIDs[num-1]);
	window.location="editor.php";
	return true;
}

function deleteUPresent(num) {
	$.ajax({
		type: 'POST',
		url: root_url + 'deletePresentation',
		data: deleteFormToJSON(presNames[num-1]),
		async: false,
		success: function(){
			window.location="user.php";
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
	return true;
}

// Helper function to serialize all the form fields into a JSON string
function deleteFormToJSON(presName) {
	return JSON.stringify({
		"title" : presName
	});
}