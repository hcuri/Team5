<!--new.html-->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_user.css" rel="stylesheet"/>
<link href="css/styles_new.css" rel="stylesheet"/>
<script src="js/main.js"></script>
<title>UPresent -- New</title>
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
<h1>New UPresent</h1>
<div id="content">
<form id="createNew" action="editor.php" method="post">
  <div id="block">
    <div id="info">
      <label for="title">Title:</label>
      <input type="text" name="title"/>
      <br/>
      <label for="date">Date:</label>
      <input type="date" name="date"/>
      <br/>
      <label for="private">Private?</label>
      <input type="checkbox" name="private">
      </input>
      <!--Code input?--> 
    </div>
    <div id="divider"></div>
    <div id="fileinfo">
      <p>Please upload PDF:</p>
      <br/>
      <input type="file" name="browse" value="Browse my Computer"/>
    </div>
    <br/>
  </div>
  <div id="bottomBlock">
    <div id="buttons">
      <input type="submit" name="create" value="Create UPresent"/>
      <input type="button" name="cancel" value="Cancel" onclick="window.location='user.php'"/>
    </div>
  </div>
</form>
</div>
<div id="footer">UPresent 2014 | <a href="index.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>
