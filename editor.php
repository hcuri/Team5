<?php
  require_once("FileParser/FileParser.php"); 
  $FileParser = new FileParser();
  $FileParser->modifyPresentation($_FILES["files"], $_POST['title']);
?>

<!--editor.html-->
<!DOCTYPE HTML>
<html>
<head>
  <link href="css/styles_editor.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <link href="css/jQuery.css" rel="stylesheet" />
  <script src="js/jQuery.js"></script>
  <script src="js/editor.js"></script>
  <title>UPresent - Editor</title>
</head>
<body>

<!-- Invite viewers window START -->
<div id="fadeout"></div>
<div id="invContainer">
  <div id="userSearch">
    <center><span>Search Users</span></center>
    <div id="searchBar">
      <input type="text" id="searchBox" />
      <img src="img/searchBtn.png" />
    </div>
    <div id="tableHolder">
      <table>
        <tr class="1">
          <td class="header">First Name</td>
          <td class="header">Last Name</td>
          <td class="header">Username</td>
          <td class="header">Add to Group</td>
        </tr>
        <tr class="2">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="3">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="4">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="5">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="6">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="7">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="8">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="9">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="10">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="11">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="12">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="13">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="14">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="15">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="16">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="17">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="18">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
        <tr class="19">
          <td class="fName"></td>
          <td class="lName"></td>
          <td class="username"></td>
          <td class="addToGroup"></td>
        </tr>
      </table>
    </div>
  </div>
  <div id="vertbar"></div>
  <div id="groups">
    <center><span>My Groups</span></center>
    <div id="searchBar">
      <input type="text" id="groupBox" /><img src="img/plusBtn.png" />
      <div id="groupInfo"></div>
    </div>
    <div id="groupTable">
      <!--<div id="gName"><img src="img/minusBtn.png" />Group 1<input type="radio" name="groupNum" value="1"></div>
        <div id="uName">Taylor Bishop <img src="img/trash.png" /></div>
        <div id="uName">Hector Curi<img src="img/trash.png" /></div>
        <div id="uName">John Politz<img src="img/trash.png" /></div>
      <div id="gName"><img src="img/minusBtn.png" />Group 2<input type="radio" name="groupNum" value="2"></div>
        <div id="uName">Nick Morris<img src="img/trash.png" /></div>
        <div id="uName">Tyler George<img src="img/trash.png" /></div>
        <div id="uName">Hector's Mom<img src="img/trash.png" /></div>-->
    </div>
  </div>
  <input id="cancel" type="submit" name="submit" value="Cancel"/>
  <div id="uErr"></div>
  <div id="gErr"></div>
  <input id="done" type="submit" name="submit" value="Done"/>
</div>
<!-- Invite viewers window END -->

<div id="header">
  <div id="insideHeader"><A id="logoLink" HREF="index.php"><img id="logo" src="img/OfficialMiniLogo.png"/></A>
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
  <div id="UPresentTitle">
    <h1>Lecture 11 By Chris Raley</h1>
  </div>
  <div id="PollAdderForm">
    <form id="PollData" action="" method="post" onclick="return addPoll(this)">
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
    <form id="save" action="user.php" method="post">
      <input type="submit" id="saveUPresent" value="Save UPresent" />
      </form>
      <input type="submit" id="inv" value="Invite Viewers" />
      <span id="LogoMessage">Created with <img id="bottomlogo" src="img/logoS.png"/> </span>
    </form>
  </div>
</div>
</body>
</html>