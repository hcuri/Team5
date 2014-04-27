function createPresentation() {
	alert(root_url);
	var bool = false;
	$.ajax({
		type: 'POST',
		url: root_url + 'addPresentation',
		data: presFormToJSON(),
		async: false,
		success: function(){
			alert('Presentation created successfully');
			bool = true;
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