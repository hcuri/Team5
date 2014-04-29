<!--invite.html-->
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/styles.css" rel="stylesheet" />
<link href="css/styles_invite.css" rel="stylesheet"/>
<script src="js/jQuery.js"></script>
<script src="js/main.js"></script>
<title>UPresent -- Invite</title>
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
  <div id="wrapper">
    <div id="invite">
      <input type="text" name="viewersearch" value="Search for users"/>
      <table id="availableUsers">
        <tr>
          <td class="iName">Larry Brown</td>
          <td class="iW"><input type="button" name="invite" value="Invite"/></td>
        </tr>
        <tr>
          <td class="iName">Nic Moore</td>
          <td class="iW"><input type="button" name="invite" value="Invite"/></td>
        </tr>
        <tr>
          <td class="iName">Nick Russell</td>
          <td class="iW"><input type="button" name="invite" value="Invite"/></td>
        </tr>
        <tr>
          <td class="iName">Marcus Kennedy</td>
          <td class="iW"><input type="button" name="invite" value="Invite"/></td>
        </tr>
        <tr>
          <td class="iName">Keith Frazier</td>
          <td class="iW"><input type="button" name="invite" value="Invite"/></td>
        </tr>
        <tr>
          <td class="iName">Shaun Williams</td>
          <td class="iW"><input type="button" name="invite" value="Invite"/></td>
        </tr>
        <tr>
          <td class="iName">Sterling Brown</td>
          <td class="iW"><input type="button" name="invite" value="Invite"/></td>
        </tr>
      </table>
    </div>
    <div id="divider"></div>
    <div id="invited">
      <h2>Invited Users</h2>
      <table id="invitedUsers">
        <tr>
          <td class="iName">John Wayne</td>
          <td class="iW"><input type="button" name="remove" value="Remove"/></td>
        </tr>
        <tr>
          <td class="iName">Clint Eastwood</td>
          <td class="iW"><input type="button" name="remove" value="Remove"/></td>
        </tr>
        <tr>
          <td class="iName">Patrick Stewart</td>
          <td class="iW"><input type="button" name="remove" value="Remove"/></td>
        </tr>
        <tr>
          <td class="iName"></td>
          <td class="iW"></td>
        </tr>
        <tr>
          <td class="iName"></td>
          <td class="iW"></td>
        </tr>
        <tr>
          <td class="iName"></td>
          <td class="iW"></td>
        </tr>
        <tr>
          <td class="iName"></td>
          <td class="iW"></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>