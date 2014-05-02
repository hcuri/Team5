// JavaScript Document

$(document).ready(function(e) {
    var today = new Date().toISOString().split('T')[0];
	$("#datePick").attr("min", today);
});