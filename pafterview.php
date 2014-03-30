<!--pafterview.html-->
<!DOCTYPE HTML>
<html>
    <head>
        <title>UPresent - Presenter Afterview</title>
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
    </body>
</html>