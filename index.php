<?php
  //echo "fuck your cookies " . $_COOKIE['user'];
?>

<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link href="css/styles_home.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <script src="js/main.js"></script>
  <script src="js/jQuery.js"></script>
  <title>UPresent.org</title>
</head>

<body>
<div id="header"><div id="insideHeader"> <img id="logo" src="img/OfficialMiniLogo.png"/>
  <div id="logInPane">
    <?php
      $logInForm =  '<form id="login" action="" method="post" onSubmit="return checkLogin(this)">
                      <input id="logInUsername" type="username" name="username" placeholder="Username" required/>
                      <input id="logInPassword" type="password" name="password" placeholder="Password" required/>
                      <input id="logInSubmit" type="submit" name="submit" value="Log In"/>
                    </form>';
      if (!empty($_COOKIE['user'])) {
        $logout = 'Welcome, ' . $_COOKIE["user"] . '!   <input id="logoutSubmit" type="submit" name="submit" value="Log Out" onClick="logout()" />';
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
  <div id="info">
    <div id="infoHeader">Welcome to UPresent!</div>
    <div id="infoContent"> UPresent is an in-browser software service that lets you upload your presentations online and share them with the entire class. Just upload you presentation, join a group, and watch as it displays across everyone in the session!</div>
    <IMG SRC="img/OfficialLogo.png" />
  </div>
  <div id="signUpWindow">
    <div id="signUpHeader">Sign Up!</div>
    <div id="signUpContent">
      <form id="signUp" action="" method="post" onSubmit="return checkRegister(this)">
        <input id="signUpFname" type="text" name="fname" placeholder="First Name" required/>
        <input id="signUpLname" type="text" name="lname" placeholder="Last Name" required/>
        <input id="signUpUsername" type="text" name="username" placeholder="Username" required/>
        <input id="signUpEmail" type="email" name="email" placeholder="Email" required/>
        <input id="signUpPassword" type="password" name="password" placeholder="Password" required/>
        <input id="signUpPasswordC" type="password" name="passwordC" placeholder="Confirm Password" required/>
        <input id="signUpSubmit" type="submit" name="submit" value="Sign Up" />
      </form>
    </div>
  </div>
</div>
<div id="footer">UPresent 2014 | About | Terms | Privacy | Contact </div>
</body>
</html>
