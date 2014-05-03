<?php
  if(!empty($_FILES['files'])) {
    require_once("api/FileParser.php"); 
    $FileParser = new FileParser();
    $FileParser->modifyPresentation($_FILES['files'], $_COOKIE['presName']);
  }

  $title = $_COOKIE['presName'];
 
?>

<!--editor.html-->
<!DOCTYPE HTML>
<html>
<head>
  <link href="css/styles_editor.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <link href="css/jQuery.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/feature-carousel.css" charset="utf-8" />
  <script src="js/root_url.js"></script>
  <script src="js/jQuery.js"></script>
  <script src="js/jquery.featureCarousel.js" type="text/javascript" charset="utf-8"></script>
  <script src="js/jquery.cookie.js"></script>
  <script src="js/main.js"></script>
  <script src="js/editor.js"></script>
  <!--<script type="text/javascript">
      $(document).ready(function() {
        var carousel = $("#carousel").featureCarousel({
          // include options like this:
          // (use quotes only for string values, and no trailing comma after last option)
          // option: value,
          // option: value
          autoPlay: 0
        });


      });
    </script> -->
  <title>Edit UPresent</title>
</head>
<body>

<!-- Invite viewers window START -->
<div id="fadeout"></div>
<div id="invContainer">
  <div id="userSearch">
    <center><span>Search Users</span></center>
    <div id="searchBar">
      <input type="text" id="searchBox" />
      <img id="searchBtn" src="img/searchBtn.png" />
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
      <input type="text" id="groupBox" /><img id="plusBtn" src="img/plusBtn.png" />
      <div id="groupInfo"></div>
    </div>
    <div id="groupTable">
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
      ?>
      <script>console.log(document.cookie);</script> 
    </div>
  </div>
</div>
<div id="content" style="height: 930px;">
  <div id="UPresentTitle">
    <h1><?php echo $_COOKIE['presName']; ?></h1>
  </div>

  <!--Photo Gallery -->
  <div class="carousel-container">
    
      <div id="carousel">
      </div>
    
      <div id="carousel-left"><img src="img/arrow-left.png" /></div>
      <div id="carousel-right"><img src="img/arrow-right.png" /></div>
    </div>


  <div id="PollAdderForm">
      <div id="pollHead"><div id="pollTitle"><span>Slide Poll</span></div></div>
      <div id="pollContainer">
        <label for="PollQuestion">Question</label><br />
        <input id="PollQuestion" type="text" name="PollQuestion" placeholder="Write your question here" size="50" /><div id="qErr"></div>
        <br>
        <br>
        Options<br>
        <label for="OptionA">A</label>
        <input id="OptionA" id="OptionA" type="text" placeholder="Option A text here" size="50"/>
        <div id="oErr"></div>
        <br>
        <label for="OptionB">B</label>
        <input id="OptionB" id="OptionB" type="text" placeholder="Option B text here" size="50"/>
        <br>
        <label for="OptionC">C</label>
        <input id="OptionC" id="OptionC" type="text" placeholder="Option C text here" size="50"/>
        <br>
        <label for="OptionD">D</label>
        <input id="OptionD" id="OptionD" type="text" placeholder="Option D text here" size="50"/>
        <br>
        <label for="OptionE">E</label>
        <input id="OptionE" id="OptionE" type="text" placeholder="Option E text here" size="50"/>
        <br>
        <label for="OptionF">F</label>
        <input id="OptionF" id="OptionF" type="text" placeholder="Option F text here" size="50"/>
        <br>
        <input id="showGraph"  type="checkbox" name="showGraph" value="true" />
        <label for="showGraph">Show results on presentation?</label>
        <br>
        <br>
        <input type="submit" id="pollSubmit" value="Add Poll to Slide" />
      </div>
  </div>
  <div id="saveSubmit">
    <input type="submit" id="inv" value="Invite Viewers" />
    <div></div>
    <input type="submit" id="saveUPresent" value="Save UPresent" />
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>