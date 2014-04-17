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
				currEntry.eq(j).html("<input class=\"present\" type=\"button\" value=\"Present\" onclick=\"window.location='presenter.php'\">");
			} else if(j===2){
				currEntry.eq(j).html("<input class=\"edit\" type=\"button\" value=\"Edit\" onclick=\"window.location='editor.php'\">");
			} else {
				currEntry.eq(j).html("<img class=\"trashIcon\" src=\"img/trash.png\">");
			}
		}
	}
	$(".present").click(function(event) {
		row = event.target.parentNode.parentNode;
		row = $(row).attr('class');
		presentUPresent(presIDs[row-1]);
	});
	
	$(".edit").click(function(event) {
		row = event.target.parentNode.parentNode;
		row = $(row).attr('class');
		editUPresent(presIDs[row-1]);
	});
	
	$(".trashIcon").click(function(event) {
		row = event.target.parentNode.parentNode;
		row = $(row).attr('class');
		deleteUPresent(presIDs[row-1]);
	});
	
	$( "#dialog-confirm" ).dialog({
      resizable: false,
	  autoOpen: false,
      height:140,
      modal: true,
      buttons: {
        "Delete UPresent": function() {
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
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

function presentUPresent(num) {
	//call ajax to delete presentation from the parameter
	alert("Presenting: " + presNames[row-1]);
	return true;
}

function editUPresent(num) {
	//call ajax to delete presentation from the parameter
	alert("Editing: " + presNames[row-1]);
	return true;
}

function deleteUPresent(num) {
	//call ajax to delete presentation from the parameter
	alert("Deleting: " + presNames[num-1] + " : " + presIDs[num-1]);
	//alert("test");
	//$("#deleteName").html("Deleting: " + presNames[num-1] + " Are You Sure?");
	//alert("test2");
	//$( "#dialog-confirm" ).dialog("open");
	$.ajax({
		type: 'POST',
		url: root_url + 'deletePresentation',
		data: deleteFormToJSON(presNames[num-1]),
		async: false,
		success: function(){
			alert("UPresent Deleted");
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
	alert(JSON.stringify({
		"title" : presName
	}));
	return JSON.stringify({
		"title" : presName
	});
}

