<!--newGroup.php-->
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="css/styles_user.css" rel="stylesheet" />
		<link href="css/styles.css" rel="stylesheet" />
		<link href="css/jQuery.css" rel="stylesheet" />
		<script src="js/jQuery.js"></script>
		<script src="js/jquery-1.10.2.js"></script>
		<script src="js/user.js"></script>
		<script src="js/main.js"></script>
	</head>
	<body>
		<div id="header">
  			<div id="insideHeader"><A id="logoLink" HREF="user.php"><img id="logo" src="img/OfficialMiniLogo.png"/></A>
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




		</div>
	</body>
</html>