function createPresentation() {
	var bool = false;
	$.ajax({
		type: 'POST',
		url: root_url + 'addPresentation',
		data: presFormToJSON(),
		async: false,
                dataType: "json",
		success: function(msg){
                        if(msg.error == "false")
                            bool = true;
                        else
                            alert("You already have a presentation with this name");
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('Something went wrong\ncreatePresentation() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
			bool = false;
		}
	});

	return bool;
}

function presFormToJSON() {
	return JSON.stringify({
		"title": $('#title').val(),
		"date": $('#date').val(),
		"time": $('#time').val()
	});
}