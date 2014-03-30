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
    <div id="insideHeader"><A HREF="user.php"><img id="logo" src="img/OfficialMiniLogo.png"/></A>
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
  <div id="tabs1">
    <ul>
      <li><a href="#tabs1-1">Current</a></li>
      <li><a href="#tabs1-2">Ready</a></li>
    </ul>
    <div id="tabs1-1">
      <table>
        <tr>
          <th class="title">Title</th>
          <th class="edit">Edit</th>
          <th class="erase">Erase</th>
        </tr>
        <tr>
          <td class="title">My First Presentation</td>
          <td class="edit"><input type="button" value="Edit"></td>
          <td class="erase"><img class="trashIcon" src="img/trash.png"></td>
        </tr>
        <tr>
          <td class="title">How to Make a UPresent</td>
          <td class="edit"><input type="button" value="Edit"></td>
          <td class="erase"><img class="trashIcon" src="img/trash.png"></td>
        </tr>
        <tr>
          <td class="title">The Origin of Species</td>
          <td class="edit"><input type="button" value="Edit"></td>
          <td class="erase"><img class="trashIcon" src="img/trash.png"></td>
        </tr>
        <tr>
          <td class="title">GUI Presentations</td>
          <td class="edit"><input type="button" value="Edit"></td>
          <td class="erase"><img class="trashIcon" src="img/trash.png"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="edit"></td>
          <td class="erase"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="edit"></td>
          <td class="erase"></td>
        </tr>
      </table>
    </div>
    <div id="tabs1-2">
      <table>
        <tr>
          <th class="title">Title</th>
          <th class="date">Date</th>
          <th class="view">View</th>
        </tr>
        <tr>
          <td class="title">Next UPresent</td>
          <td class="date">3/5/14</td>
          <td class="view"><input type="button" value="Present" onclick="window.location='presenter.php'"></td>
        </tr>
        <tr>
          <td class="title">Old UPresent</td>
          <td class="date">2/8/14</td>
          <td class="view"><input type="button" value="View" onclick="window.location='pafterview.php'"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="date"></td>
          <td class="view"></td>
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
      <li><a href="#tabs2-2">Past Presentations</a></li>
    </ul>
    <div id="tabs2-1">
      <table>
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
          <td class="view"><input type="button" value="View"></td>
        </tr>
        <tr>
          <td class="title">Intro to iOS</td>
          <td class="author">Hector Curi</td>
          <td class="date">1/29/14</td>
          <td class="view"><input type="button" value="View"></td>
        </tr>
        <tr>
          <td class="title">My Search Engine</td>
          <td class="author">Larry Page</td>
          <td class="date">1/29/14</td>
          <td class="view"><input type="button" value="View"></td>
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
      <table>
        <tr>
          <th class="title">Title</th>
          <th class="author">Author</th>
          <th class="date">Date</th>
          <th class="view">View</th>
        <tr>
          <td class="title">Learning From Me</td>
          <td class="author">Steve Jobs</td>
          <td class="date">1/15/2012</td>
          <td class="view"><input type="button" value="View"></td>
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
        <tr>
          <td class="title"></td>
          <td class="author"></td>
          <td class="date"></td>
          <td class="view"></td>
        </tr>
        <tr>
          <td class="title"></td>
          <td class="author"></td>
          <td></td>
          <td></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<div id="footer">UPresent 2014 | About | Terms | Privacy | Contact </div>
</body>
</html>
