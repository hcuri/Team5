<!--contact.html-->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/styles_home.css" rel="stylesheet" />
	<link href="css/styles.css" rel="stylesheet" />
	<link href="css/styles_contact.css" rel="stylesheet"/>
	<link href="css/styles_user.css" rel="stylesheet"/>
	<title>UPresent -- Contact Us</title>
</head>
<body>
	<div id="header">
	  <div id="insideHeader"><A HREF="user.php"><img id="logo" src="img/OfficialMiniLogo.png"/></A>
	    <div id="logInPane">
	      <?php
	        $logInForm =  '<form id="login" action="" method="post" onSubmit="return checkLogin(this)">
	                        <input id="logInUsername" type="username" name="username" placeholder="Username" required/>
	                        <input id="logInPassword" type="password" name="password" placeholder="Password" required/>
	                        <input id="logInSubmit" type="submit" name="submit" value="Log In"/>
	                      </form>';
	        if (!empty($_COOKIE['user'])) {
	          $logout = '<DIV ID="logout">Welcome, <span id="logoutUsername">' . $_COOKIE["user"] . '</span>!   <input id="logoutSubmit" type="submit" name="submit" value="Log Out" onClick="logout()" /></DIV>';
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
	<div id="contact">
		<form>
			<h1>Contact UPresent</h1>
			<p>We are here to help you with any questions or comments.</p>
			<input type="text" name="username" value="Username"/><br/>
			<input type="text" name="subject" value="Subject"/><br/>
			<textarea id="message" wrap="hard">
				Here is some sample text for your pleasure.  Hopefully
				you can find this helpful to your endeavours.
			</textarea><br/>

			<input id="request" type="button" value="Send Request"/>

		</form>
	</div>
        </div>
	<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>