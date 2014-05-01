<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_viewer.css" rel="stylesheet" />
<link href="css/jQuery.css" rel="stylesheet" />
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
    </script>
<script src="js/jQuery.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/main.js"></script>
<script src="js/slides.js"></script>
<title>UPresent Viewer</title>
</head>

<body>
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
    </div>
  </div>
</div>
<div id="content">
  <div id="viewer">
    <div id="info">
      <div class="oLine"></div>
      <h2 id="presName"></h2>
      by
      <h3 id="presAuthor"></h3>
      <div class="oLine"></div>
    </div>
    <div id="slidePane"> <img id="slide" src=""/></div>
    <div id="status">
      <div class="oLine"></div>
      <h3>Slide</h3>
      <h2 id="slideNum"></h2>
      <div class="oLine"></div>
    </div>
  </div>
  <div id="bottomInfo">
    <div id="bInfoData">
      <table id="pollQuestions">
        <tr>
          <th></th>
          <th class="question"></th>
        </tr>
        <tr>
          <td>A</td>
          <td class="q"></td>
        </tr>
        <tr>
          <td>B</td>
          <td class="q"></td>
        </tr>
        <tr>
          <td>C</td>
          <td class="q"></td>
        </tr>
        <tr>
          <td>D</td>
          <td class="q"></td>
        </tr>
      </table>
    </div>
    <div id="bInfoGraph">
      <table id="pollSubmission">
        <tr>
          <td id="responseA" class="submitButton">A</td>
          <td id="responseB" class="submitButton">B</td>
        </tr>
        <tr>
          <td id="responseC" class="submitButton">C</td>
          <td id="responseD" class="submitButton">D</td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>