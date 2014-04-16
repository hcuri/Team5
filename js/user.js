// JavaScript Document

var presNames = new Array();
var presIDs = new Array();

$(document).ready(function() {
	$("#tabs1").tabs();
	$( "#tabs2" ).tabs();
	$("#newPres").click(function() {
		alert("Creating New Presentation");
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
	var pres = pres.responseJSON;
	
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
				currEntry.eq(j).click(function() {
					alert("Editing");
				});
				currEntry.eq(j).html("<input type=\"button\" value=\"Present\" onclick=\"window.location='editor.php'\">");
			} else if(j===2){
				currEntry.eq(j).click(function() {
					alert("Editing UPresent");
				});
				currEntry.eq(j).html("<input type=\"button\" value=\"Edit\" onclick=\"window.location='editor.php'\">");
			} else {
				currEntry.eq(j).click(function() {
				});
				currEntry.eq(j).html("<img class=\"trashIcon\" src=\"img/trash.png\">");
				
			}
		}
	}
	$(".trashIcon").click(function(event) {
		row = event.target.parentNode.parentNode;
		row = $(row).attr('class');
		deleteUPresent(presIDs[row-1]);
	});
	
	//fill upcoming table
	var entries = $("#upcoming").children().children();
	for(var i = 1; i < entries.length+1; i++) {
		var currEntry = entries.eq(i).children();
		for(var j = 0; j < 4; j++) {
			if(j<3) {
				currEntry.eq(j).html("test");
			} else {
				currEntry.eq(j).click(function() {
					alert("Viewing");
				});
				currEntry.eq(j).html("<input type=\"button\" value=\"View\" onclick=\"window.location='afterview.php'\">");
			}
		}
	}
	
	//fill past presentation table
	//BASE OFF THIS
	var entries = $("#past").children().children();
	for(var i = 1; i < entries.length+1; i++) {
		var currEntry = entries.eq(i).children();
		for(var j = 0; j < 4; j++) {
			if(j<3) {
				currEntry.eq(j).html("test");
			} else {
				currEntry.eq(j).click(function() {
					alert("Viewing");
				});
				currEntry.eq(j).html("<input type=\"button\" value=\"View\" onclick=\"window.location='afterview.php'\">");
			}
		}
	}
});

function count(obj) {
  var i = 0;
  for (var x in obj)
    if (obj.hasOwnProperty(x))
      i++;
  return i;
}

function deleteUPresent(num) {
	//call ajax to delete presentation from the parameter
	alert("Deleting: " + presNames[row-1]);
	return true;
}

