<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_presenter.css" rel="stylesheet" />
<link href="css/jQuery.css" rel="stylesheet" />
<script src="js/jQuery.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/viewer.js"></script>
<script src="js/main.js"></script>
<title>UPresent Presenter</title>
</head>

<body>
<div id="header">
  <div id="insideHeader"><a href="user.php"> <img id="logo" src="img/OfficialMiniLogo.png"/></a> <input type="button" value="End Presentation" onclick="window.location='pafterview.php'"/></div>
  <!--<div id="navButtons">
    <div id="home"><a href="#home">Home</a></div>
    <div id="account"><a href="#account">Account</a></div>
    <div id="logOff"><a href="#logOff">Log Off</a></div>
  </div>--> 
</div>
<div id="content">
  <div id="viewer">
    <div id="info">
      <div class="oLine"></div>
      <img id="previous" class="smallSlide" src="img/slide1.jpg"/>
      <div class="oLine"></div>
    </div>
    <div id="slidePane"> <img id="slide" src="img/slide2.jpg"/></div>
    <div id="status">
      <div class="oLine"></div>
      <img id="next" class="smallSlide" src="img/slide3.jpg"/>
      <div class="oLine"></div>
    </div>
  </div>
  <div id="bottom">
    <div id="presentNotes">
      <textarea rows="5" cols="50" placeholder="Enter Notes Here..."> </textarea>
    </div>
    <div id="pollResults"><img id="pollR" src="img/poll.png" /></div>
  </div>
</div>
<div id="footer">UPresent 2014 | About | Terms | Privacy | Contact </div>
</body>
</html>
