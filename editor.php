<?php
  require_once("FileParser/FileParser.php"); 
  $FileParser = new FileParser();
  $FileParser->modifyPresentation($_FILES['files'], $_POST['title']);
  setcookie('presName', $_POST['title']);

  $title = $_POST['title'];
?>

<!--editor.html-->
<!DOCTYPE HTML>
<html>
<head>
  <link href="css/styles_editor.css" rel="stylesheet" />
  <link href="css/styles.css" rel="stylesheet" />
  <link href="css/jQuery.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/feature-carousel.css" charset="utf-8" />
  <script src="js/jQuery.js"></script>
  <script src="js/jquery.featureCarousel.js" type="text/javascript" charset="utf-8"></script>
  <script src="js/jquery.cookie.js"></script>
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
<div id="content" style="height: 840px;">
  <div id="UPresentTitle">
    <h1><?php echo $_POST['title']; ?></h1>
  </div>

  <!--Photo Gallery -->
  <div class="carousel-container">
    
      <div id="carousel">
        <!-- <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample1.jpg" /></a>
          <div class="carousel-caption">
            <p>
              This area is typically used to display captions associated with the images. They are set to hide and fade in on rotation.
            </p>
          </div>
        </div>
        <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample2.jpg" /></a>
          <div class="carousel-caption">
            <p>
              The background will expand up or down to fit the caption.
            </p>
          </div>
        </div>
        <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample3.jpg" /></a>
          <div class="carousel-caption">
            <p>
              Images can be placed here as well.
            </p>
          </div>
        </div>
        <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample4.jpg" /></a>
        </div>
        <div class="carousel-feature">
          <a href="#"><img class="carousel-image" alt="Image Caption" src="img/sample5.jpg" /></a>
          <div class="carousel-caption">
            <p>
              The background color of the caption area can be changed using CSS. The opacity can be changed in the options, but it will also change the opacity of the text.
            <p>
          </div>
        </div> -->
      </div>
    
      <div id="carousel-left"><img src="img/arrow-left.png" /></div>
      <div id="carousel-right"><img src="img/arrow-right.png" /></div>
    </div>


  <div id="PollAdderForm">
      <div id="pollHead"><div id="pollTitle"><span>Slide Poll</span></div></div>
      <div id="pollContainer">
        <label for="PollQuestion">Question</label><br />
        <input id="PollQuestion" type="text" name="PollQuestion" placeholder="Write your question here" size="50" />
        <br>
        <br>
        Correct<br>
        <label for="OptionA">A</label>
        <input id="OptionA" id="OptionA" type="text" placeholder="Option A text here" size="50"/>
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
    <input type="submit" id="saveUPresent" value="Save UPresent" />
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>