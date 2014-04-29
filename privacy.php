<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles_home.css" rel="stylesheet" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_about.css" rel="stylesheet" />
<script src="js/jQuery.js"></script>
<script src="js/cookies.js"></script>
<script src="js/main.js"></script>
<title>UPresent - Privacy</title>
</head>

<body>
  <div id="backgroundScreen">
    <img src="img/newbackground.jpg" class="stretch">
  </div>
<div id="header">
  <div id="insideHeader"><A HREF="index.php"><img id="logo" src="img/OfficialMiniLogo.png"/></A>
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
        //echo '<SCRIPT TYPE="text/javascript">alert("' . $_COOKIE["user"] . '");</SCRIPT>';
      ?>
      <script>console.log(document.cookie);</script> 
    </div>
  </div>
</div>
<div id="content">
  <div id="terms">
    <div id="infoHeader">UPresent Privacy</div>
    <div id="infoContent">Here is where UPresent.org is going to explain how user information is processed and kept private from organizations like NSA, CIA, etc; in order to keep our users happy and safe.</div>
  </div>
  
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>










