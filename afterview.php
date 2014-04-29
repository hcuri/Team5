<!--afterview.html-->
<!DOCTYPE HTML>
<html>
<head>
<link href="css/styles_afterview.css" rel="stylesheet" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/jQuery.css" rel="stylesheet" />
<script src="js/jQuery.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/editor.js"></script>
<script src="js/main.js"></script>
<title>UPresent - Afterview</title>
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

<div id="backgroundScreen">
  <img src="img/background.jpg" class="stretch">
</div>
<div id="content"> 
  
  <!--Title-->
  <div id="UPresentTitle">
    <h1>Lecture 11 By Chris Raley</h1>
  </div>
  
  <!--Left Side Content-->
  <div id="LeftCol">
    <div id="Slides"> <img src="img/coverview.png" /> </div>
    <!--<div id="NoteSection">
      <form id="notes">
        <fieldset>
          <legend>Notes</legend>
          <textarea id="notesection">       
            You can still type or correct your notes here after you watch the presentation.
            They will be stored automatically along the specific slide that you were viewing at the moment.
          </textarea>
        </fieldset>
      </form>
    </div>-->
  </div>
  <!--<div id="vline"></div>-->
  
  <!--Right Side-->
  <!--<div id="RightCol">
    <div id="Chat">
      <fieldset>
        <legend>Viewers Chat</legend>
        <textarea id="chatHistory"> <!--rows="15" cols="63"
          User1: I really liked Raley's UPresent
                                      
          User2: Yeah, he's awesome!
                                      
          User3: I have something important to say to all. "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                                      
          User1: That's boring
        </textarea>
        <form id="chatForm">
          <input id="chatInput" type="text" name="chatInput" placeholder="You can comment and chat here" size="50"/>
          <input id="chatSubmit" type="button" value="Send"/>
        </form>
      </fieldset>
    </div>-->
    <div id="Options">
      <input id="download" type="button" value="Download Slides" />
      <form id="contactPresenter" action="contact.php">
        <input id="contact" type="submit" value="Contact Presenter" />
      </form>
    </div>
  </div>
  

  <div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
  <!--Footer-->
  <!--<div id="Footer">
    <form id="save">
      <input type="button" id="home" value="Home" onclick="window.location='user.php'" />
      <span id="LogoMessage">Created with <img id="bottomlogo" src="img/logoS.png"/></span>
    </form>
  </div>-->
</div>
</body>
</html>