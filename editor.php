<!--editor.html-->
<!DOCTYPE HTML>
<html>
<head>
  <link href="css/styles_editor.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <link href="css/jQuery.css" rel="stylesheet" />
  <script src="js/jQuery.js"></script>
  <script src="js/editor.js"></script>
  <script src="js/jquery-1.10.2.js"></script>
  <title>UPresent - Editor</title>
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
<div id="content">
  <div id="UPresentTitle">
    <h1>Lecture 11 By Chris Raley</h1>
  </div>
  <div id="PollAdderForm">
    <form id="PollData">
      <fieldset>
        <legend>Add Poll</legend>
        <label for="PollQuestion">Question</label>
        <input id="PollQuestion" type="text" name="PollQuestion" placeholder="Write your question here" size="50"/>
        <br>
        <BR>
        Correct<br>
        <label for="OptionA">A</label>
        <input id="OptionA" name="OptionA" type="text" placeholder="Option A - Answer" size="50"/>
        <input type="radio" name="options" value="a" checked/>
        <br>
        <label for="OptionB">B</label>
        <input id="OptionB" name="OptionB" type="text" placeholder="Option B - Answer" size="50"/>
        <input type="radio" name="options" value="b" />
        <br>
        <label for="OptionC">C</label>
        <input id="OptionC" name="OptionC" type="text" placeholder="Option C - Answer" size="50"/>
        <input type="radio" name="options" value="c" />
        <br>
        <label for="OptionD">D</label>
        <input id="OptionD" name="OptionD" type="text" placeholder="Option D - Answer" size="50"/>
        <input type="radio" name="options" value="d" />
        <br>
        <input id="showGraph"  type="checkbox" name="showGraph" value="true" />
        <label for="showGraph">Show Poll Graph on next slide?</label>
        <br>
        <br>
        <input type="submit" value="Add Poll to Slide" />
      </fieldset>
    </form>
  </div>
  <div id="SlidesPreview"> <img src="img/coverview.png" /> </div>
  <div id="NoteSection">
    <form id="notes">
      <fieldset>
        <legend>Presenter Notes</legend>
        <textarea rows="10" cols="142">       
    Write helpful notes here. You will be able to view them when you are presenting.
                    </textarea>
      </fieldset>
    </form>
  </div>
  <div id="Footer">
    <form id="save">
      <input type="button" id="saveUPresent" value="Save UPresent" />
      <input type="button" id="inviteViewers" value="Invite Viewers" />
      <span id="LogoMessage">Created with <img id="bottomlogo" src="img/logoS.png"/> </span>
    </form>
  </div>
</div>
</body>
</html>