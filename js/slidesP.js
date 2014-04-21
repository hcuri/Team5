// JavaScript Document

var root_url = "http://localhost/UPresent/api/index.php";
var slides = new Array();
var currentSlide = 1;
var numSlides;	
var presID = null;

$(document).ready(function(e) {
	//var getPresID = $.ajax({
	//	type: 'GET',
	//	url: root_url + "/getPresInfo",
	//	dataType: "json",
	//	async: false,
	//});
        //alert(JSON.stringify(presID));
	//getPresID = getPresID.responseJSON;
	presID = $.cookie('pres');
 
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
	
	$("#slide").attr("src", slides[1]);
        if(numSlides > 1)
            $("#next").attr("src", slides[2]);
        else {
            $("#next").attr("src", ""); //need contingincy for this
            $("#next").css("background-color", "black");
        }
	
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

// Helper function to serialize all the form fields into a JSON string
function slideFormToJSON() {
	return JSON.stringify({
		"presId" : presID,
		"currSlide": currentSlide
	});
}