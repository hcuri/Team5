<!doctype html>
<!--This is a comment-->
<html>
<head>
	<title>Taco Truck -- Payment</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/styles.css" rel="stylesheet">
	<link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet" />
	<script src="js/jQuery.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/main.js"></script>
</head>

<body>
<div id="topBar"> <img src="img/taco_truck_logo.png" id="logo">
<div id="links"> <a href="#homepage">Home</a> | <a href="#account">Account</a> | <a href="#cart">Cart</a> | <a href="#logoff">Log Off</a>
    <div id="divider"></div>
  </div>
  	<form name="payment" action="user.html" method="post">
	  <div>First Name:
	    <input type="text" id="fName" name="fName"/>
	  </div>
	  <div>Last Name:
	    <input type="text" id="lName" name="lName"/>
	  </div>
	  <div>Email:
	    <input type="email" id="email" name="email"/>
	  </div>
	  <div>Password:
	    <input type="password" id="pwd" name="pwd"/>
	  </div>
	  <div>Confirm Password:
	    <input type="password" id="pwdC" name="pwdC"/>
	  </div>
	  <div>Card Provider:
	    <select id="ccType" name="ccType">
	      <option value="AE">American Express</option>
	      <option value="MC">MasterCard</option>
	      <option value="V">Visa</option>
	    </select>
	  </div>
	  <div>Card Number:
	    <input type="text" id="ccNum" name="ccNum"/>
	  </div>
	  <input type="submit" id="register" name="register" value="Sign Up"/>
	</form>
</div>

<h1 style="text-align:center">Taco Payment</h1>


</body>
<footer>
  <div style="text-align:center">Taco Truck |<a href="#locations">123 Taco Avenue - Dallas - TX - 75205</a>| 214-MY-TACOS (214-698-2267) |<a href="#homepage">tacotruck.com</a>| Hours: 24/7</div>
</footer>
</html>
