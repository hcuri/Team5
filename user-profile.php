<!--user-profile.html-->
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/styles_home.css" rel="stylesheet" />
	<link href="css/styles.css" rel="stylesheet" />
	<link href="css/styles_user.css" rel="stylesheet" />
	<link href="css/styles_user-profile.css" rel="stylesheet" />
	<title>UPresent -- User Profile</title>
</head>
<body>
	<div id="header">
	  <div id="insideHeader"><A HREF="index.php"><img id="logo" src="img/OfficialMiniLogo.png"/></A>
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
	<!--use JavaScript to pull in current values to fill these textfields-->
	<div id="content">
		<div id="block">
			<div id="profile">
				<form name="profile">
					<label for="firstname">First Name:</label>
					<input type="text" name="firstname"/><br/>
					<label for="lastname">Last Name:</label>
					<input type="text" name="lastname"/><br/>
					<label for="email">Email:</label>
					<input type="email" name="email"/><br/>
					<label for="school/org">School/Organization:</label>
					<input type="text" name="school/org"/><br/>
					<label for="id">School/Organization ID:</label>
					<input type="text" name="id"/><br/>
					<input type="submit" name="update" value="Update Profile"/>
				</form>
			</div>
			<div id="divider"></div>
			<div id="preview">
				<h3>Profile Preview</h3>
				<img src="img" alt="Profile Picture">
				<div id="geninfo">
					<h2>Larry Brown</h2>
					<h5>lbrown@smu.edu</h5>
					<p>Joined on May 12th, 2012</p>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">UPresent 2014 | About | Terms | Privacy | Contact </div>
	<!--<div id="footer">UPresent 2014 | About | Terms | Privacy | Contact </div>-->
</body>
</html>