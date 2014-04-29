<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles_home.css" rel="stylesheet" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_about.css" rel="stylesheet" />
<script src="js/jQuery.js"></script>
<script src="js/cookies.js"></script>
<script src="js/main.js"></script>
<title>UPresent - About</title>
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
      <!--<img src="img/OfficialLogo.png" style="margin-left:250px" />-->
    <div id="infoHeader">About Us</div>
    <div id="infoContent">
      UPresent began in early spring 2014, when five SMU students realized a dream to make classroom 
      presentations bearable.  UPresent allows users to upload slideshow presentations onto the web,
      add polling data to different slides, invite people to view their UPresents, and make the 
      presentation experience more streamlined and efficient.  What began as a simple idea has transformed
      into a successful venture.  Spread the word!
    </div>
  </div>
  
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>










