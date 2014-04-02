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
});
