var root_url = "http://localhost/UPresent/api/index.php/";

function submitContact() {
    $.ajax({
        type: 'POST',
        url: root_url + 'email',
        data: contactFormToJSON(),
        async: true,
	success: function(){
            alert('Email sent successfully');
	},
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR + 'Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
        }
    });
    return true;
}

    function contactFormToJSON() {
    return JSON.stringify({
        "name": $('#userN').val(),
        "subject": $('#subject').val(),
        "message": $('#message').val()        
    });
}   