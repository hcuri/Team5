// JavaScript Document

var slides = new Array();
var currentSlide = null;
var updatedSlide = null;	
var presID = null;
var numSlides;
var poll = false;
var pollDone = false;
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
var elem = null;
var openFS = null;
var fullS = false;
var backToFS = false;

$(document).ready(function(e) {
	presID = $.cookie('pres');
	
	elem = document.getElementById("slide");
	openFS = elem.requestFullScreen || elem.webkitRequestFullScreen || elem.mozRequestFullScreen;

	$("#bottomInfo").css("display", "none");
	$("#bInfoData").css("display", "none");
	$("#content").css("height", "475");
 
  	$("#previous").css("background-color", "black");
	$("#previous").removeAttr("src");

	var slidesJSON = $.ajax({
		type: 'GET',
		url: root_url + "getSlides/" + presID,
		dataType: "json",
		async: false,
	});
	slidesJSON = slidesJSON.responseJSON;
	numSlides = slidesJSON.numSlides;
	slides = slidesJSON.slides;
	$("div#presTitle").text($.cookie('presName'));

	$("#slide").attr("src", slides[1]);
        if(numSlides > 1)
            $("#next").attr("src", slides[2]);
        else {
            $("#next").attr("src", ""); //need contingincy for this
            $("#next").css("background-color", "black");
        }
	$("#slide").click(function() {
		if(fullS) {
    		document.webkitCancelFullScreen();
			fullS = false;
		} else {
			openFS.call(elem);
			updatedSlide--;
			fullS = true;
		}
	});

	$("#slide").click(function() {
                if(currentSlide < numSlides) {
                    updatedSlide++;
                    updateSlide();
                }
	});
	$("#previous").click(function() {
		if(currentSlide > 1) {
		updatedSlide--;
		updateSlide();
		}
	});
	$("#next").click(function() {
            if(currentSlide < numSlides) {
		updatedSlide++;
		updateSlide();
            }
	});

	$(document).keydown(function(e) {
		if(e.keyCode == 37) {
			if(currentSlide > 1) {
				updatedSlide--;
				updateSlide();
			}
		}
		if(e.keyCode == 39) {
			if(currentSlide < numSlides) {
				updatedSlide++;
				updateSlide();
			}
		}
	});
    $("#endPres").click(function() {
    	finishPresentation();
	});
	$("#resetPoll").click(function() {
					console.log("reset activated");
    				$.ajax({
						type: 'POST',
						url: root_url + 'resetPoll',
						data: resetFormToJSON(),
						async: false,
						success: function(){
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
						}
					});
				});
	
});

var getCurrSlide = setInterval(function() {
		var cS = $.ajax({
			type: 'GET',
			url: root_url + "getCurrentSlide/" + presID,
			dataType: "json",
			async: false,
		});
		cS = cS.responseJSON;
		if(currentSlide !== cS.currSlide){
			currentSlide = cS.currSlide;
			updatedSlide = currentSlide;
			poll = cS.poll;
			pollDone = !poll;
			updateSlide();
		}

		if(poll) {
			if(fullS) {
				document.webkitCancelFullScreen();
				fullS = false;
			}
			$( "#content" ).animate({
				height: 725
			}, 500, function() {	
				$("#bottomInfo").css("display", "block");
				$("#bInfoData").css("display", "block");
				$( "#bottomInfo" ).animate({
					opacity: 1
				}, 500, function() {
				});	
			});

			var pollJSON = $.ajax({
				type: 'GET',
				url: root_url + "getPollInfo/" + presID + "/" + currentSlide,
				dataType: "json",
				async: false,
			});
			pollJSON = pollJSON.responseJSON;
			console.log(JSON.stringify(pollJSON));

			var q = pollJSON.question;
			var opts = pollJSON.options;
			numQ = pollJSON.numOptions;

			$(".question").html(q);

			var qS = document.getElementsByClassName("q");

			var tableContents = '<tr><th></th><th class="question">' + q +'</th></tr>';
			
			for(var i = 0; i < numQ; i++) {
				tableContents += '<tr><td>' + letters[i] + '</td><td class="q">' + opts[letters[i]] + '</td></tr>';
			}
			
			$("#bInfoData").html(tableContents);

			chart = new google.visualization.ColumnChart(document.getElementById('bInfoGraph'));
			
			//SWITCH
			
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
				
			chart.draw(data, options);
			
			setInterval(getPollResults,1000);
			poll = false;
			pollDone = false;

		} else if (pollDone) {
			clearInterval(getPollResults);
			$( "#bottomInfo" ).animate({
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

			pollDone = false;
		}
}, 1000);



function updateSlide() {
	$("#slide").attr("src", slides[updatedSlide]);

	if(updatedSlide < 2) {
		$("#next").attr("src", slides[updatedSlide+1]);
		$("#previous").attr("src", "");
		$("#previous").css("background-color", "black");
	} else if(updatedSlide == numSlides) {
		$("#previous").attr("src", slides[updatedSlide-1]);
		$("#next").attr("src", "");
		$("#next").css("background-color", "black");
	} else {
		$("#previous").attr("src", slides[updatedSlide-1]);
		$("#next").attr("src", slides[updatedSlide+1]);
	}

	$.ajax({
		type: 'POST',
		url: root_url + 'setCurrentSlide',
		data: slideFormToJSON(),
		async: false,
		success: function(){
			//alert("Slide Changed");
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});

}

//CHECK FOR NEW UPDATES TO POLL
function getPollResults() {
	while(liveResults.length > 0) {
		liveResults.pop();
	}

	var result = $.ajax({
		type: 'GET',
		url: root_url + "getPollResults/" + presID + "/" + currentSlide,
		dataType: "json",
		async: false,
	});
	result = result.responseJSON;
	var rS = document.getElementsByClassName("r");

	for(var i = 0; i < numQ; i++) {
		data.setValue(i, 1, result[i].option_results);
		$(rS[i]).html(result[i].option_results);
	}
	chart.draw(data, options);
};

// Helper function to serialize all the form fields into a JSON string
function slideFormToJSON(pN) {
	return JSON.stringify({
		"presId" : presID,
		"currSlide": updatedSlide
	});

}

function finishPresentation() {
    $.ajax({
		type: 'POST',
		url: root_url + 'finishPresentation',
		data: endFormToJSON(),
		async: false,
		success: function(msg){
			//alert(msg); //no longer throws error
		},
		error: function(jqXHR, textStatus, errorThrown){
			console.log(jqXHR + ' Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
	});
}

function endFormToJSON() {
    return JSON.stringify({
        "presId" : presID
    });
}

function resetFormToJSON() {
    return JSON.stringify({
        "presId" : presID,
		"slide" : currentSlide
    });
}