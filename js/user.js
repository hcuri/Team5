// user.js: fill tables with user information and navigate presenting and viewing

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
		window.location = root_root_url + "new.php";
	});
	
	var userN = $("#logoutUsername").html();
	document.title = userN + "'s UPresents";
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
	if(numUPres > 6) {
		for(var i = 7; i <= numUPres; i++) {
			$('table#current tr:last').after('<tr class="' + i + '"><td class="title"></td><td class="present"></td><td class="edit"></td><td class="erase"></td></tr>');
		}
	}

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
		upPresAuthor.push(pres[i].ownerName);
		upPresDate.push(pres[i].presDate);
		upPresIDs.push(pres[i].presId);
	}
	
	if(numUPres > 6) {
		var addNum = numUPres - 6;
		for(var i = addNum; i <= numUPres; i++) {
			$('table#upcoming tr:last').after('<tr class="' + i + '"><td class="title"></td><td class="present"></td><td class="edit"></td><td class="erase"></td></tr>');
		}
	}
	//fill upcoming table
	var entries = $("#upcoming").children().children();
	for(var i = 0; i < numUPres; i++) {
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
		viewUpcomingUPresent(row);
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
		pastPresAuthor.push(pres[i].ownerName);
		pastPresDate.push(pres[i].presDate);
		pastPresIDs.push(pres[i].presId);	
	}
	
	if(numUPres > 6) {
		var addNum = numUPres - 6;
		for(var i = addNum; i <= numUPres; i++) {
			$('table#past tr:last').after('<tr class="' + i + '"><td class="title"></td><td class="present"></td><td class="edit"></td><td class="erase"></td></tr>');
		}
	}
	//fill past presentation table
	//BASE OFF THIS
	var entries = $("#past").children().children();
	for(var i = 0; i < numUPres; i++) {
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
	$.cookie('pres', presIDs[num-1], {path: '/'});
        $.ajax({
            type: 'POST',
            url: root_url + 'setCurrentSlide',
            data: slideFormToJSON(num),
            async: false,
            success: function(){
            	//alert("Slide Changed");
            },
            error: function(jqXHR, textStatus, errorThrown){
            	alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
            }
        });
        window.location=root_root_url + "presenter.php";
	return true;
}

function editUPresent(num) {
	//call ajax to delete presentation from the parameter
	$.cookie('pres', presIDs[num-1], {path: '/'});
        $.cookie('presName', presNames[num-1], {path: '/'});
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
		"title" : presName,
                "username" : $.cookie('user')
	});
}

//TABLE 2 FUNCTIONS
function viewUpcomingUPresent(num) {
	$.cookie('pres', upPresIDs[num-1], {path: '/'});
    window.location="viewer.php";
	return true;
}
function viewPastUPresent(num) {
	$.cookie('pres', pastPresIDs[num-1], {path: '/'});
    window.location="afterview.php";
	return true;
}

function slideFormToJSON(num) {
	return JSON.stringify({
		"presId" : presIDs[num - 1],
		"currSlide": 1
	});
}