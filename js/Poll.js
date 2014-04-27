var root_url = "http://localhost/UPresent/api/index.php/";

$(document).ready(function(){
    
    var info = [];
    info[0] = 'HI';
    info[1] = 'YOU';
    $.ajax({
        type: 'POST',
        url: root_url + 'createPoll',
        data: {info: info},
        async: true,
        success: function(msg) {
            alert(msg);
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
        }
        
        
    });
    
});