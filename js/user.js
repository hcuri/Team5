// JavaScript Document

$(document).ready(function() {
	//$( "#tabs1" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    //$( "#tabs1 li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	$("#tabs1").tabs();
	$( "#tabs2" ).tabs();
	$("#newPres").click(function() {
		alert("Creating New Presentation");
		window.location = "http://localhost/new.php";
	});
	$(".trashIcon").click(function() {
		alert("Deleting UPresent");
	});
	
	
	/*var pastData = $.ajax({
		type: 'GET',
		url: root_url + "getPastPres",
		dataType: "json",
		async: false,
	});
	var pastData = pastData.responseJSON;
	var numPres = pastData.count;*/
	
	//fill current table
	var entries = $("#current").children().children();
	for(var i = 1; i < entries.length+1; i++) {
		var currEntry = entries.eq(i).children();
		for(var j = 0; j < 4; j++) {
			currEntry.eq(j).html("test");
			if(j===3) {
				currEntry.eq(j).click();
			}
		}
	}
	
	//fill ready table
	var entries = $("#ready").children().children();
	for(var i = 1; i < entries.length+1; i++) {
		var currEntry = entries.eq(i).children();
		for(var j = 0; j < 4; j++) {
			currEntry.eq(j).html("test");
			if(j===3) {
				currEntry.eq(j).click();
			}
		}
	}
	
	//fill upcoming table
	var entries = $("#upcoming").children().children();
	for(var i = 1; i < entries.length+1; i++) {
		var currEntry = entries.eq(i).children();
		for(var j = 0; j < 4; j++) {
			currEntry.eq(j).html("test");
			if(j===3) {
				currEntry.eq(j).click();
			}
		}
	}
	
	//fill past presentation table
	var entries = $("#past").children().children();
	for(var i = 1; i < entries.length+1; i++) {
		var currEntry = entries.eq(i).children();
		for(var j = 0; j < 4; j++) {
			currEntry.eq(j).html("test");
			if(j===3) {
				currEntry.eq(j).click();
			}
		}
	}
});
