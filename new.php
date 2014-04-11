<!--new.html-->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_user.css" rel="stylesheet"/>
<link href="css/styles_new.css" rel="stylesheet"/>
<link href="css/jQuery.css" rel="stylesheet" />
<script src="js/jQuery.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/new.js"></script>
<script src="js/main.js"></script>
<title>UPresent -- New</title>
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
      <label for="session">Session:</label>
      <input id="session" type="text" name="session"/>
      <br/>
      <label for="private">Create Session?</label>
      <input type="checkbox" name="private">
      </input>
      <br/>
      <label for="group">Group</label>
      <select name="group">
      <option>Test</option>
      <option>Test2</option>
      </select>
      <br/>
      <label for="date">Date?</label>
      <input type="date" name="date">
      </input>
      <br/>
      <label for="private">Is Private?</label>
      <input type="checkbox" name="private">
      </input>
      <!--Code input?--> 
    </div>
    <div id="divider"></div>
    <div id="fileinfo">
      <p>Please upload PDF:</p>
      <br/>
      <span id="fileUpload"><input type="file" name="files[]"  multiple directory webkitdirectory mozdirectory></span>
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
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>
