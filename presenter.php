<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_presenter.css" rel="stylesheet" />
<link href="css/jQuery.css" rel="stylesheet" />
<script src="js/root_url.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
    </script>
<script src="js/jQuery.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/main.js"></script>
<script src="js/slidesP.js"></script>
<script src="js/fullscreen.js"></script>
<title>Presenting Presentation</title>
</head>

<body>
<div id="header">
  <div id="insideHeader"><A id="logoLink" HREF="index.php"><img id="logo" src="img/OfficialMiniLogo.png"/></A>
    <div id="logInPane">
      <?php
        $logInForm =  '<form id="login" action="user.php" method="post" onSubmit="return checkLogin(this)">
                        <input id="logInUsername" type="username" name="username" placeholder="Username" required/>
                        <input id="logInPassword" type="password" name="password" placeholder="Password" required/>
                        <input id="logInSubmit" type="submit" name="submit" value="Log In"/>
                      </form>';
        if (!empty($_COOKIE['user'])) {
          $logout = '<DIV ID="logout">Welcome, <a id="logoutUsername" href="user-profile.php">' . $_COOKIE["user"] . '</a>!   <input id="logoutSubmit" type="submit" name="submit" value="Log Out" onClick="logout()" /></DIV>';
          echo $logout;
        }
        else {
          echo $logInForm;
        }
      ?>
    </div>
  </div>
</div>
<div id="content">
  <div id="presTitle"></div>
  <div id="viewer">
    <div id="info">
      <div class="oLine"></div>
      <img id="previous" class="smallSlide" src=""/>
      <div class="oLine"></div>
    </div>
    <div id="slidePane"><img id="slide" src="" /></div>
    <div id="status">
      <div class="oLine"></div>
      <img id="next" class="smallSlide" src=""/>
      <div class="oLine"></div>
    </div>
  </div>
  <div id="endPres">
    <form id="end" action="user.php">
      <input id="endUpres" type="submit" value="End UPresent">
    </form>
  </div>
  <div id="bottomInfo">
    <div id="bInfoData">
      <table id="pollQuestions">
      </table>
    </div>
    <div id="bInfoGraph"> </div>
    <div id="resetP"><input id="resetPoll" type="button" value="Reset Poll"></div>
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>