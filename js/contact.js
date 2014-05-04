function flashErr(errMsg) {
    $('div#cErr span').text("");
    $('div#cErr span').css({opacity: 0.0});
    $('div#cErr span').text(errMsg);
    $("div#cErr span").animate({opacity: 1.0}, "slow", function(){
      $("div#cErr span").delay(3000).animate({opacity: 0.0}, "slow");
    });
}

function submitContact() {
    var msg = $("#message").val();
    if(msg === "") {
        flashErr("   Please fill out the message field.");
        return false;
    }
    else {
        $.ajax({
            type: 'POST',
            url: root_url + 'email',
            data: contactFormToJSON(),
            async: true,
            success: function(msg) {
                alert(msg);
            },
            error: function(jqXHR, textStatus, errorThrown) {
			alert('Something went wrong\n email() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
		}
        });
        //alert("Email sent successfully");
        return true;
    }
}

function contactFormToJSON() {
    var cookie = $.cookie('user');

    if(typeof cookie === 'undefined') {
        return JSON.stringify({
            "name": $('#userN').val(),
            "subject": $('#subject').val(),
            "message": $('#message').val()        
        });
    }
    else {
        return JSON.stringify({
            "name": $.cookie('user'),
            "subject": $('#subject').val(),
            "message": $('#message').val()        
        });
    }
}   