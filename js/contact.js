var root_url = "http://localhost/UPresent/api/index.php/";

function submitContact(cform) {
    alert("HI");
    $.ajax({
        type: 'POST',
        url: root_url + 'email',
        data: contactFormToJSON(),
        async: true,
	success: function(){
            alert('email sent successfully');
	},
        error: function(jqXHR, textStatus, errorThrown){
            alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
        }
    });
}

    function contactFormToJSON() {
    return JSON.stringify({
        "name": $('#userN').val()
    });
}   