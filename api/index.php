<?php

require 'Slim/Slim.php';
require '../php/lib.php';

$app = new Slim();

$app->get('/verify/:username/:pass', 'verifyRegistered');
$app->get('/registered/:email', 'checkIfRegistered');
$app->post('/register', 'registerUser');

$app->run();]

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

function checkIfRegistered($email) {
	$sql = "SELECT * FROM Users WHERE email=:email";

	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("email", $email);
		$stmt->execute();  
		if($stmt->rowCount() > 0)
			echo '{"email_registered": true}';  
		else 
			echo '{"email_registered": false}';
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function registerUser() {
	error_log('addUser\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$user = json_decode($request->getBody());
	$pass = password_hash($user->pw, PASSWORD_DEFAULT);
	$sql = "INSERT INTO Users VALUES (DEFAULT, 'NONE', 'NONE', :username, :pass, :email, 'NONE')";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("username", $user->username);
		$stmt->bindParam("pass", $pass);
		$stmt->bindParam("email", $user->email);
	       	$stmt->execute();
		$db = null; 
		echo json_encode($user); 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}
?>