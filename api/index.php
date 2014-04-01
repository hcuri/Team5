<?php
require 'Slim/Slim.php';
require '../php/lib.php';
require '../php/password.php';

$app = new Slim();

$app->get('/verify/:username/:pass', 'verifyRegistered');
$app->get('/registered/:email/:username', 'checkIfRegistered');
$app->get('/logout', 'logoutUser');
$app->get('/getUserInfo', 'getUserInfo');
$app->post('/postUserInfo', 'postUserInfo');
$app->post('/register', 'registerUser');
$app->post('/addPresentation', 'addPresentation');

//Group functions
$app->get('/getGroupMembers', 'getGroupMembers');
$app->post('/createGroup', 'createGroup');
$app->post('/addToGroup', 'addToGroup');
$app->post('/deleteFromGroup', 'deleteFromGroup');
$app->post('/deleteGroup', 'deleteGroup');
$app->run();

function verifyRegistered($username, $password) {
	$sql = "SELECT * FROM Users WHERE username=:username";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("username", $username);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
			if(password_verify($password, $userInfo['password'])) {
				echo '{"registered": true}';
				setcookie("user", $username, time()+3600, '/');
			}
			else echo '{"registered": false}';	
		}
		else echo '{"registered": false}';
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function checkIfRegistered($email, $username) {
	$sqlEmail = "SELECT * FROM Users WHERE email=:email";
	$sqlUsername = "SELECT * FROM Users WHERE username=:username";

	try {
		$db = dbconnect();

		// Check email
		$stmt = $db->prepare($sqlEmail);  
		$stmt->bindParam("email", $email);
		$stmt->execute();  
		if($stmt->rowCount() > 0)
			echo '{"email": true,';  
		else 
			echo '{"email": false,';

		// Check username
		$stmt = $db->prepare($sqlUsername);  
		$stmt->bindParam("username", $username);
		$stmt->execute();  
		if($stmt->rowCount() > 0)
			echo '"username": true}';  
		else 
			echo '"username": false}';
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function registerUser() {
	error_log('addUser\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$user = json_decode($request->getBody());
	$pass = password_hash($user->pass, PASSWORD_DEFAULT);
	$sql = "INSERT INTO Users VALUES (DEFAULT, :fName, :lName, :username, :email, :pass, 'NONE', 'NONE', 'NONE')";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("fName", $user->fName);
		$stmt->bindParam("lName", $user->lName);
		$stmt->bindParam("username", $user->username);
		$stmt->bindParam("email", $user->email);
		$stmt->bindParam("pass", $pass);
	    $stmt->execute();
		$db = null; 
		setcookie("user", $user->username, time()+3600, '/');
		echo json_encode($user); 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function logoutUser() {
    setcookie("user", "", time() - 3600, '/');
	echo '{"loggedOut": "true"}';
}

function addPresentation() {
	error_log('addPresentation\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$presentation = json_decode($request->getBody());
	$sql = "INSERT INTO Presentations VALUES (DEFAULT, :presURL, :chatURL, 'NONE', :username)";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("presURL", $presentation->presURL);
		$stmt->bindParam("chatURL", $presentation->chatURL);
		$stmt->bindParam("sessId", $presentation->sessId);
		$stmt->bindParam("username", $presentation->username);
	    $stmt->execute();
		$db = null; 
		echo json_encode($presentation); 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}	
}

function getUserInfo() {
	$errorInfo = '{"error": "true"}';

	if (!empty($_COOKIE['user'])) {
        $username = $_COOKIE['user'];
    }
	$sql = "SELECT * FROM Users WHERE username=:username";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("username", $username);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
			echo json_encode($userInfo);
		}
		else {
			echo $errorInfo;
		}
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function postUserInfo() {
	error_log('postUserInfo\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$user = json_decode($request->getBody());

	$sql = "UPDATE Users 
			SET fName = :fName, lName = :lName, email = :email, organization = :organization, schoolID = :schoolID
			WHERE username = :username";

	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("username", $user->username);
		$stmt->bindParam("fName", $user->fName);
		$stmt->bindParam("lName", $user->lName);
		$stmt->bindParam("email", $user->email);
		$stmt->bindParam("organization", $user->organization);
		$stmt->bindParam("schoolID", $user->schoolID);
	    $stmt->execute();
		$db = null;  
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

//function getPresentation() {

//}

?>
