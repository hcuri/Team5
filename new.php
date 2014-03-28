<!--new.html-->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_user.css" rel="stylesheet"/>
<link href="css/styles_new.css" rel="stylesheet"/>
<title>UPresent -- New</title>
</head>
<body>
<div id="header">
  <div id="insideHeader"> <img id="logo" src="img/OfficialMiniLogo.png"/></div>
</div>
<h1>New UPresent</h1>
<div id="content">
  <div id="block">
    <div id="info">
      <label for="title">Title:</label>
      <input type="text" name="title"/>
      <br/>
      <label for="date">Date:</label>
      <input type="date" name="date"/>
      <br/>
      <label for="private">Private?</label>
      <input type="checkbox" name="private">
      </input>
      <!--Code input?--> 
    </div>
    <div id="divider"></div>
    <div id="fileinfo">
      <p>Please upload PDF:</p>
      <br/>
      <input type="file" name="browse" value="Browse my Computer"/>
    </div>
    <br/>
  </div>
  <div id="bottomBlock">
    <div id="buttons">
      <input type="button" name="create" value="Create UPresent"/>
      <input type="button" name="cancel" value="Cancel"/>
    </div>
  </div>
</div>
<!--<div id="footer">UPresent 2014 | About | Terms | Privacy | Contact </div>-->
</div>
</body>
</html>