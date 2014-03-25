<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles_home.css" rel="stylesheet" />
<link href="css/styles.css" rel="stylesheet" />
<script src="js/main.js"></script>
<script src="js/jQuery.js"></script>
<title>UPresent.org</title>
</head>

<body>
<div id="header"> <img id="logo" src="img/logo.png"/>
  <div id="logInPane">
    <form id="login" action="" method="post" onSubmit="return checkLogin(this)">
      <input id="logInUsername" type="username" name="username" placeholder="Username" required/>
      <input id="logInPassword" type="password" name="password" placeholder="Password" required/>
      <input id="logInSubmit" type="submit" name="submit" value="Log In"/>
    </form>
  </div>
</div>
<div id="content">
  <div id="info">
    <div id="infoHeader"> Create Interactive Presentations and Share Them with UPresent</div>
    <div id="infoContent"> INFO BOX WITH LOADS OF TEXT AND FANTASTIC INFORMATION ABOUT UPRESENT</div>
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
