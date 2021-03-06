<!--contact.html-->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles_home.css" rel="stylesheet" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_about.css" rel="stylesheet" />
<link href="css/styles_user.css" rel="stylesheet"/>
<link href="css/styles_contact.css" rel="stylesheet"/>
<script src="js/root_url.js"></script>
<script src="js/jQuery.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/main.js"></script>
<script src="js/contact.js"></script>
<title>Contact Team5!</title>
</head>
<body>
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
    </div>
  </div>
</div>
<div id="content">
  <div id="contact">
    <form id="contact" action="index.php" method="post" onSubmit="return submitContact()">
      <h2>Contact UPresent</h2>
      <div id="uDiv">
        <label for="username" id="uHead">Username:</label>

        <?php
          if (!empty($_COOKIE['user']))  echo '<div id="usernameContact">' . $_COOKIE['user'] . '</div>';
          else                           echo '<input id="userN" type="text" name="username" placeholder="Username" size="50" required />';
        ?>
      </div>
      <br/>
      <div id="subDiv">
        <label for="subject" id="subHead">Subject:</label>
        <input id="subject" type="text" name="subject" placeholder="Subject" size="50" required />
      </div>
      <br/>
      <label>Message:</label>
      <br/>
      <textarea id="message" wrap="hard"></textarea>
      <br/>
      <div id="cErr"><input id="request" type="submit" value="Send Email" /><span></span></div>
    </form>
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>