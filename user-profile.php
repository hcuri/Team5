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
  		<div id="insideHeader"> <img id="logo" src="img/OfficialMiniLogo.png"/></div>
	</div>
	<!--use JavaScript to pull in current values to fill these textfields-->
	<div id="content">
		<div id="profile">
			<form name="profile">
				<label for="firstname">First Name:</label>
				<input type="text" name="firstname"/>
				<label for="lastname">Last Name:</label>
				<input type="text" name="lastname"/>
				<label for="email">Email:</label>
				<input type="email" name="email"/>
				<label for="school/org">School/Organization</label>
				<input type="text" name="school/org"/>
				<label for="id">School/Organization ID</label>
				<input type="text" name="id"/><br/>
				<input type="submit" name="update" value="Update Profile"/>
			</form>
		</div>
	</div>

	<!--<div id="footer">UPresent 2014 | About | Terms | Privacy | Contact </div>-->
</body>
</html>