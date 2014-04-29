<!--user-profile.html-->
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href="css/styles_home.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <link href="css/styles_user.css" rel="stylesheet" />
  <link href="css/styles_user-profile.css" rel="stylesheet" />
  <link href="css/jQuery.css" rel="stylesheet" />
  <script src="js/jQuery.js"></script>
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/user_profile.js"></script>
  <script src="js/main.js"></script>
  <title>UPresent -- User Profile</title>
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
        //echo '<SCRIPT TYPE="text/javascript">alert("' . $_COOKIE["user"] . '");</SCRIPT>';
      ?>
      <script>console.log(document.cookie);</script> 
    </div>
  </div>
</div>
<!--use JavaScript to pull in current values to fill these textfields-->
<div id="backgroundScreen">
  <img src="img/background.jpg" class="stretch">
</div>
<div id="content">
  <div id="block">
    <div id="profile">
      <form id="userInfo" name="profile" action="user-profile.php" onSubmit="updateProfile(this)">
        <label for="firstname">First Name:</label>
        <input id="fName" type="text" name="firstname"/>
        <br/>
        <label for="lastname">Last Name:</label>
        <input id="lName" type="text" name="lastname"/>
        <br/>
        <label for="email">Email:</label>
        <input id="email" type="email" name="email"/>
        <br/>
        <label for="school/org">School/Organization:</label>
        <input id="org" type="text" name="school/org"/>
        <br/>
        <label for="id">School/Organization ID:</label>
        <input id="orgID" type="text" name="id"/>
        <br/>
        <input type="submit" name="update" value="Update Profile"/>
      </form>
      <form id="return" name="home" action="user.php">
        <input type="submit" name="home" value="Home" />
      </form>
    </div>
    <div id="divider"></div>
    <div id="preview">
      <h3>Profile Preview</h3>
      <img src="img/identicon.png" alt="Profile Picture">
      <div id="geninfo">
        <h2 id="fullName">Larry Brown</h2>
        <h3 id="userName">jackjp</h3>
        <h5 id="userEmail">lbrown@smu.edu</h5>
      </div>
    </div>
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
<!--<div id="footer">UPresent 2014 | About | Terms | Privacy | Contact </div>-->
</body>
</html>