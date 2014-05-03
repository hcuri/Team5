$(document).ready(function(){
    
    var info = [];
    info[0] = 'HI';
    info[1] = 'YOU';
    var jsonInfo = JSON.stringify(info);
    alert(jsonInfo);
    $.ajax({
        type: 'POST',
        url: root_url + 'createPoll',
        data: {info: jsonInfo},
        async: true,
        success: function(msg) {
            alert(msg);
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert(jqXHR + ', Something went wrong\nregister() error: ' + textStatus + "\nerrorThrown: " + errorThrown);
        }
        
        
    });
    
});