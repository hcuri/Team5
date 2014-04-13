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
      <li><a href="#tabs1-1">In Progress</a></li>
      <li><a href="#tabs1-2">Completed</a></li>
    </ul>
    <div id="tabs1-1">
      <table id="current">
        <tr>
          <th class="title">Title</th>
          <th class="edit">Edit</th>
          <th class="erase">Erase</th>
        </tr>
        <tr>
          <td class="title">My First Presentation</td>
          <td class="edit"></td>
          <td class="erase"></td>
        </tr>
        <tr>
          <td class="title">How to Make a UPresent</td>
          <td class="edit"><input type="button" value="Edit" onclick="window.location='editor.php'"></td>
          <td class="erase"><img class="trashIcon" src="img/trash.png"></td>
        </tr>
        <tr>
          <td class="title">The Origin of Species</td>
          <td class="edit"><input type="button" value="Edit" onclick="window.location='editor.php'"></td>
          <td class="erase"><img class="trashIcon" src="img/trash.png"></td>
        </tr>
        <tr>
          <td class="title">GUI Presentations</td>
          <td class="edit"><input type="button" value="Edit" onclick="window.location='editor.php'"></td>
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
      <table id="ready">
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
  <div id="tabs3">
<<<<<<< HEAD
    <div id="tabs3-1">
      <table id="groups">
        <tr>
          <th class="title">Name</th>
          <th class="author">Creator</th>
        </tr>
        <tr id="group1">
          <td class="title">Justice League</td>
          <td class="author">Batman</td>
        </tr>
        <tr id="group2">
          <td class="title">The Jedi</td>
          <td class="author">Yoda</td>
        </tr>
        <tr id="group3">
          <td class="title">The Expendables</td>
          <td class="author">Sly Stallone</td>
        </tr>
        <tr id="group4">
          <td class="title">Dumbledore's Army</td>
          <td class="author">Harry Potter</td>
        </tr>
        <tr id="group5">
          <td class="title">SMU Mustangs</td>
          <td class="author">Larry Brown</td>
        </tr>
        <tr id="group6">
          <td class="title">Dallas Cowboys</td>
          <td class="author">Jerry Jones</td>
        </tr>
      </table>
    </div>
    <div id="groupStuff">
      <div id="createGroup">
        <form id="newG" action="newGroup.php">
          <input id="newGroup" type="submit" value="Create Group">
        </form>
      </div>
      <div id="searchGroup">
        <form id="searchG" action="searchterms.php">
          <input id="sGroup" type="submit" value="Search for Group">
        </form>
      </div>
      <div id="addtoGroup">
        <form id="addG" action="something.php">
          <input id="aGroup" type="submit" value="Add to Group">
        </form>
      </div>
      <div id="leaveGroup">
        <form id="leaveG" action="something.php">
          <input id="lGroup" type="submit" value="Leave Group">
        </form>
      </div>
    </div>
=======
    <table id="groups">
      <tr>
        <th class="title">Name</th>
        <th class="author">Creator</th>
      </tr>
      <tr id="group1">
        <td class="title">Justice League</td>
        <td class="author">Batman</td>
      </tr>
      <tr id="group2">
        <td class="title">The Jedi</td>
        <td class="author">Yoda</td>
      </tr>
      <tr id="group3">
        <td class="title">The Expendables</td>
        <td class="author">Sly Stallone</td>
      </tr>
      <tr id="group4">
        <td class="title">Dumbledore's Army</td>
        <td class="author">Harry Potter</td>
      </tr>
      <tr id="group5">
        <td class="title"></td>
        <td class="author"></td>
      </tr>
      <tr id="group6">
        <td class="title"></td>
        <td class="author"></td>
      </tr>
    </table>
>>>>>>> 55d6a81f7cfbae6079398888beb8f2e97fa0ea27
  </div>
</div>
<div id="footer">UPresent 2014 | <a href="about.php">About</a> | <a href="terms.php">Terms</a> | <a href="privacy.php">Privacy</a> | <a href="contact.php">Contact</a></div>
</body>
</html>
