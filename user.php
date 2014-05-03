<!--user.html-->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles_user.css" rel="stylesheet" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/jQuery.css" rel="stylesheet" />
<!--<link href="css/jquery-ui-1.10.4.css" rel="stylesheet" />-->
<script src="js/root_url.js"></script>
<script src="js/jQuery.js"></script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/main.js"></script>
<script src="js/user.js"></script>
<title>User's UPresents Page</title>
</head>
<body>
<div id="dialog-confirm" title="Delete UPresent?">
  <div id="deleteName"></div>
</div>
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
          <td></td>
          <td></td>
          <td></td>
          <td></td>
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
        <tr class="1">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="2">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="3">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="4">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="5">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="6">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
      </table>
    </div>
    <div id="tabs2-2">
      <table id="past">
        <tr class="1">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="2">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="3">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="4">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="5">
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr class="6">
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
