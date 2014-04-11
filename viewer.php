<!DOCTYPE html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_viewer.css" rel="stylesheet" />
<link href="css/jQuery.css" rel="stylesheet" />
<script src="js/jQuery.js"></script>
<script src="js/viewer.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<title>UPresent Viewer</title>
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
<div id="content">
  <div id="viewer">
    <div id="info">
      <div class="oLine"></div>
      <h2>Lecture 11</h2>
      by
      <h3>Chris Raley</h3>
      <div class="oLine"></div>
    </div>
    <div id="slidePane"> <img id="slide" src="img/slide1.jpg"/></div>
    <div id="status">
      <div class="oLine"></div>
      <h3>Slide</h3>
      <h2>10/20</h2>
      <div class="oLine"></div>
    </div>
  </div>
  <div id="tabs">
    <ul>
      <li><a href="#tabs-1">Notes</a></li>
      <li><a href="#tabs-2">Polls</a></li>
    </ul>
    <div id="tabs-1">
      <div id="notesTab">
        <textarea rows="3" cols="50" placeholder="Enter Notes Here..."> </textarea>
      </div>
    </div>
    <div id="tabs-2">
      <div id="pollsTab">
        <div id="poll">
          <p>Please choose a response:</p>
          <br/>
          <input type="radio" name="pollResponse" value="A">
          A
          <input type="radio" name="pollResponse" value="B">
          B
          <input type="radio" name="pollResponse" value="C">
          C
          <input type="radio" name="pollResponse" value="D">
          D
        </div>
        <div id="pollResults"><img id="pollR" src="img/poll.png" /></div>
      </div>
    </div>
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>