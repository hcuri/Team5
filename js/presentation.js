function parseDate(date) {
	var d = new Date();

	//Make sure year is valid
	var year = date.match(/\d*/);
	year = year.toString();

	if(year.length > 4) {
		flashErr("Please enter a valid year.");
		return false;
	}
	else {

		//Get current date and extract date given
		var fYear = parseInt(d.getFullYear());
		var fDay = parseInt(d.getDate());
		var fMonth = parseInt(d.getMonth()) + 1;

		var gYear = parseInt(date.substr(0, 4));
		var gMonth = parseInt(date[5] + date[6]);
		var gDay = parseInt(date[8] + date[9]);

		//Check for correct date
		var bool = false;
		if(gYear < fYear)
			flashErr("You cannot give a presentation in the past!");
		else if(gYear == fYear) {
			if(gMonth < fMonth)
				flashErr("You cannot give a presentation in the past!");
			else if(gMonth == fMonth) {
				if(gDay < fDay)
					flashErr("You cannot give a presentation in the past!");
				else
					bool = true;
			}
			else
				bool = true;
		}
		else if((gYear - fYear) > 100) {
			if((gYear - fYear) > 1000) {
				flashErr("...The Earth might have blown up by that time. Please enter a valid date.");
			}
			else
				flashErr("Uhh...I don't think you'll be alive at that time to give your presentation.");
		}
		else 
			bool = true;


		return bool;
	}

}
function createPresentation() {
    var title = $('#title').val();

    var date = $("input#date").val();
    var time = $("input#time").val();

    var inp = document.getElementById('files');
    var count = 0;
    for (var i = 0; i < inp.files.length; ++i) {
        count++;
        if(count > 20)
            break;
    }
    
    if (count > 20) {
        alert("You can only upload presentations with 20 slides or less.");
        document.getElementById('files').focus();
        return false;
    }
   
    if(parseDate(date)) {
    	var bool = false;

    	$.cookie('presName', title, {path: '/'});
		$.ajax({
			type: 'POST',
			url: root_url + 'addPresentation',
			data: presFormToJSON(),
			async: false,
            dataType: "json",
			success: function(msg) {
                if(msg.error == "false")
                    bool = true;
                else 
                    flashErr("You already have a presentation with this name");
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert('Something went wrong\ncreatePresentation() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
				bool = false;
			}
		});
		return bool;
	}
	else
		return false;
}

function presFormToJSON() {
	return JSON.stringify({
		"title": $('#title').val(),
		"date": $('#date').val(),
		"time": $('#time').val()
	});
}

function flashErr(msg) {
    $('div#errBox').text("");
    $('div#errBox').text(msg);
    $('div#errBox').css({opacity: 1.0});
    $("div#errBox").animate({opacity: 1.0}, "slow", function(){
    	$("div#errBox").delay(2000).animate({opacity: 0.0}, "slow");
    });
}