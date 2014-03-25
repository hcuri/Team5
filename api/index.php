<?php

require 'Slim/Slim.php';
require '../php/lib.php';

$app = new Slim();

$app->get('/verify/:username/:pass', 'verifyRegistered');
$app->get('/registered/:email/:username', 'checkIfRegistered');
$app->post('/register', 'registerUser');

$app->run();

function verifyRegistered($username, $password) {
	$sql = "SELECT * FROM Users WHERE username=:username";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("email", $email);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
			if(password_verify($password, $userInfo['Password']))
				echo '{"registered": true}';
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
	$sql = "INSERT INTO Users VALUES (DEFAULT, :fName, :lName, :username, :email, :pass, 'NONE')";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("fName", $user->fName);
		$stmt->bindParam("lName", $user->lName);
		$stmt->bindParam("username", $user->username);
		$stmt->bindParam("email", $user->email);
		$stmt->bindParam("pass", $user->pass);
	       	$stmt->execute();
		$db = null; 
		echo json_encode($user); 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
?>
