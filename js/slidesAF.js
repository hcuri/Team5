// JavaScript Document

var slides = new Array();
var currentSlide = 1;	
var presID = null;
var numSlides;
var poll = false;
var liveResults = new Array();
var letters = ['A','B','C','D','E','F'];
var numQ;
var data;
var data1 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],]
		);
var data2 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],]
		);
var data3 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],
		['C', 0, '#FFA500'],]
		);
var data4 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],
		['C', 0, '#FFA500'],
		['D', 0, '#FF4500'],]
		);
var data5 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],
		['C', 0, '#FFA500'],
		['D', 0, '#FF4500'],
		['E', 0, '#FFD700'],]
		);
var data6 = new google.visualization.arrayToDataTable([
		['Response','Number', {role: 'style'}],
		['A', 0, '#32CD32'],
		['B', 0, '#1C86EE'],
		['C', 0, '#FFA500'],
		['D', 0, '#FF4500'],
		['E', 0, '#FFD700'],
		['F', 0, '#CD00CD'],]
		);
var chart;
var options = {
			legend: {position: 'none'},
			backgroundColor: "#FFFFFF",
			width: 525,
			height: 200,
			vAxis: {
				textStyle: {
					color: 'white',
				},
			},
        };
var draw = false;

$(document).ready(function(e) {
	presID = $.cookie('pres');
	
	$("#bottomInfo").css("display", "none");
	$("#bInfoData").css("display", "none");
	$("#content").css("height", "475");
 
  	$("#previous").css("background-color", "black");
	$("#previous").removeAttr("src");
	
	var slidesJSON = $.ajax({
		type: 'GET',
		url: root_url + "/getSlides/" + presID,
		dataType: "json",
		async: false,
	});
	slidesJSON = slidesJSON.responseJSON;
	numSlides = slidesJSON.numSlides;
	slides = slidesJSON.slides;

	$.ajax({
		type: 'GET',
		url: root_url + "/getPresInfo",
		dataType: "json",
		async: true,
		success: function(response) { 
        	$("div#titleAFView").text(response.presName);
        	document.title = response.presName + " Afterview";
      	},
      	error: function(jqXHR, textStatus, errorThrown){
          	alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
      	}
	});

	
	$("#slide").attr("src", slides[1]);
        if(numSlides > 1)
            $("#next").attr("src", slides[2]);
        else {
            $("#next").attr("src", ""); //need contingincy for this
            $("#next").css("background-color", "black");
        }
		
	getCurrSlide();
	
	$("#slide").click(function() {
                if(currentSlide < numSlides) {
                    currentSlide++;
                    updateSlide();
                }
	});
	$("#previous").click(function() {
		if(currentSlide > 1) {
		currentSlide--;
		updateSlide();
		}
	});
	$("#next").click(function() {
            if(currentSlide < numSlides) {
		currentSlide++;
		updateSlide();
            }
	});
	
	$(document).keydown(function(e) {
		if(e.keyCode == 37) {
			if(currentSlide > 1) {
				currentSlide--;
				updateSlide();
			}
		}
		if(e.keyCode == 39) {
			if(currentSlide < numSlides) {
				currentSlide++;
				updateSlide();
			}
		}
	});
});

function getCurrSlide() {
		var pollJSON = $.ajax({
				type: 'GET',
				url: root_url + "/getPollInfo/" + presID + "/" + currentSlide,
				dataType: "json",
				async: false,
		});
		pollJSON = pollJSON.responseJSON;
		var isEmpty = pollJSON.poll;
		var temp = pollJSON.showResults;
		
		if(isEmpty === "empty") {
			poll = false;
		} else {
			poll = true;		
		}
		
		if(!temp) {
			poll = false;
		}
			
		if(poll) {
			$( "#content" ).clearQueue().animate({
				height: 700
			}, 500, function() {	
				$("#bottomInfo").css("display", "block");
				$("#bInfoData").css("display", "block");
				$( "#bottomInfo" ).animate({
					opacity: 1
				}, 500, function() {
				});	
			});
			
			var q = pollJSON.question;
			var opts = pollJSON.options;
            numQ = pollJSON.numOptions;
			
			$(".question").html(q);
			
			var qS = document.getElementsByClassName("q");
			
			var tableContents = '<tr><th></th><th class="question">' + q +'</th></tr>';
			
			for(var i = 0; i < numQ; i++) {
				tableContents += '<tr><td>' + letters[i] + ':</td><td class="q">' + opts[letters[i]] + '</td></tr>';
			}
			
			switch(numQ) {
				case 1:
					data = data1;
					break;
				case 2:
					data = data2;
					break;
				case 3:
					data = data3;
					break;
				case 4:
					data = data4;
					break;
				case 5:
					data = data5;
					break;
				case 6:
					data = data6;
					break;
			}
			
			getPollResults();
			
			$("#bInfoData").html(tableContents);
		} else {
			var closed = $("#content").css("height");
			if(closed !== "475px") {
				$( "#bottomInfo" ).clearQueue().animate({
					opacity: 0
				}, 500, function() {
					$("#bInfoData").css("display", "none");
					$("#bottomInfo").css("display", "none");
					$( "#content" ).animate({
						height: 475
					}, 500, function() {
					//nothing
					});	
				});
			}
		}
}



function updateSlide() {
	$("#slide").attr("src", slides[currentSlide]);
	
	if(currentSlide < 2) {
		$("#next").attr("src", slides[currentSlide+1]);
		$("#previous").attr("src", "");
		$("#previous").css("background-color", "black");
	} else if(currentSlide == numSlides) {
		$("#previous").attr("src", slides[currentSlide-1]);
		$("#next").attr("src", "");
		$("#next").css("background-color", "black");
	} else {
		$("#previous").attr("src", slides[currentSlide-1]);
		$("#next").attr("src", slides[currentSlide+1]);
	}
	getCurrSlide();
}

//CHECK FOR NEW UPDATES TO POLL
function getPollResults() {
	var result = $.ajax({
		type: 'GET',
		url: root_url + "/getPollResults/" + presID + "/" + currentSlide,
		dataType: "json",
		async: false,
	});
	
	result = result.responseJSON;
	
	var rS = document.getElementsByClassName("r");
	
	for(var i = 0; i < numQ; i++) {
		data.setValue(i, 1, result[i].option_results);
		$(rS[i]).html(result[i].option_results);
	}
	
	chart = new google.visualization.ColumnChart(document.getElementById('bInfoGraph'));
	chart.draw(data, options);
};