<!--user.html-->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles_user.css" rel="stylesheet" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/jQuery.css" rel="stylesheet" />
<script src="js/jQuery.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/user.js"></script>
<script src="js/main.js"></script>
<title>UPresent -- User</title>
</head>
<body>
<div id="header">
  <div id="insideHeader"><A id="logoLink" HREF="user.php"><img id="logo" src="img/OfficialMiniLogo.png"/></A>
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
  <div id="tabs1">
    <ul>
      <li><a href="#tabs1-1">My UPresents</a></li>
    </ul>
    <div id="tabs1-1">
      <table id="current">
        <tr class="1">
          <td class="title"></td>
          <td class="present"></td>
          <td class="edit"></td>
          <td class="erase"></td>
        </tr>
        <tr class="2">
          <td class="title"></td>
          <td class="present"></td>
          <td class="edit"></td>
          <td class="erase"></td>
        </tr>
        <tr class="3">
          <td class="title"></td>
          <td class="present"></td>
          <td class="edit"></td>
          <td class="erase"></td>
        </tr>
        <tr class="4">
          <td class="title"></td>
          <td class="present"></td>
          <td class="edit"></td>
          <td class="erase"></td>
        </tr>
        <tr class="5">
          <td class="title"></td>
          <td class="present"></td>
          <td class="edit"></td>
          <td class="erase"></td>
        </tr>
        <tr class="6">
          <td class="title"></td>
          <td class="present"></td>
          <td class="edit"></td>
          <td class="erase"></td>
        </tr>
      </table>
    </div>
    <div id="createNew">
      <form id="new" action="new.php">
        <input id="newPres" type="submit" value="Create New UPresent">
      </form>
    </div>
  </div>
  <div id="divider"></div>
  <div id="tabs2">
    <ul>
      <li><a href="#tabs2-1">Upcoming</a></li>
      <li><a href="#tabs2-2">Past UPresents</a></li>
    </ul>
    <div id="tabs2-1">
      <table id="upcoming">
        <tr>
          <th class="title">Title</th>
          <th class="author">Author</th>
          <th class="date">Date</th>
          <th class="view">View</th>
        </tr>
        <tr>
          <td class="title">How To Design</td>
          <td class="author">Christopher Raley</td>
          <td class="date">1/29/14</td>
          <td class="view"><input type="button" value="View" onclick="window.location='viewer.php'"></td>
        </tr>
        <tr>
          <td class="title">Intro to iOS</td>
          <td class="author">Hector Curi</td>
          <td class="date">1/29/14</td>
          <td class="view"><input type="button" value="View" onclick="window.location='viewer.php'"></td>
        </tr>
        <tr>
          <td class="title">My Search Engine</td>
          <td class="author">Larry Page</td>
          <td class="date">1/29/14</td>
          <td class="view"><input type="button" value="View" onclick="window.location='viewer.php'"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
      </table>
    </div>
    <div id="tabs2-2">
      <table id="past">
        <tr>
          <th class="title">Title</th>
          <th class="author">Author</th>
          <th class="date">Date</th>
          <th class="view">View</th>
        </tr>
        <tr id="past1">
          <td class="title">Learning From Me</td>
          <td class="author">Steve Jobs</td>
          <td class="date">1/15/2012</td>
          <td class="view"></td>
        </tr>
        <tr id="past2">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr id="past3">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr id="past4">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr id="past5">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr id="past6">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>
