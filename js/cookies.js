function create_cookie(name, value) {
	var d = new Date();
	d.setTime(d.getTime()+(exdays*24*60*60*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = name + "=" + value + "; " + expires;
}

function delete_cookie(name) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function read_cookie(name) {
  if (document.cookie.length > 0) {
    var start = document.cookie.indexOf(name + "=");
    if (start != -1) {
      start = start + name.length + 1;
      var end = document.cookie.indexOf(";",start);
      if (end == -1) end = document.cookie.length;
      return unescape(document.cookie.substring(start ,end ));
    } else {
      return "";
    }
  }
  return "";
}