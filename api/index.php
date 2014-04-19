<?php
require 'Slim/Slim.php';
require '../php/lib.php';
require '../php/password.php';

$app = new Slim();

//User functions
$app->get('/verify/:username/:pass', 'verifyRegistered');
$app->get('/registered/:email/:username', 'checkIfRegistered');
$app->get('/logout', 'logoutUser');
$app->get('/getUserInfo', 'getUserInfo');
$app->get('/searchUsers/:term', 'searchUsers');
$app->get('/search/:term', 'search');
$app->get('/getPresentations/:username', 'getPresentations');
$app->post('/postUserInfo', 'postUserInfo');
$app->post('/register', 'registerUser');

//Presentation functions
$app->post('/addPresentation', 'addPresentation');
$app->get('/getSlides/:presID', 'getSlides');
$app->get('/getCurrentSlide/:presID', 'getCurrentSlide');
$app->post('/setCurrentSlide', 'setCurrentSlide');
$app->post('/deletePresentation', 'deletePresentation');
$app->post('/setPresId', 'setPresId');
$app->get('/getPresInfo', 'getPresInfo');

//Group functions
$app->get('/getGroupMembers/:groupName', 'getGroupMembers');
$app->post('/createGroup', 'createGroup');
$app->post('/addToGroup', 'addToGroup');
$app->post('/deleteFromGroup', 'deleteFromGroup');
$app->post('/deleteGroup', 'deleteGroup');


$app->run();

/* USER FUNCTIONALITY */
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
		mkdir("../upload/" . $user->username . "/");
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

	$sql = "UPDATE Users SET fName = :fName, lName = :lName, "
                . "email = :email, organization = :organization, "
                . "schoolID = :schoolID WHERE username = :username";

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

function searchUsers($term) {
    $terms = explode('|', $term);
    $numTerms = count($terms);
    
    if($numTerms == 1) {
        $sql = "SELECT fName, lName, username, organization  "
                . "FROM Users WHERE fName LIKE :term OR lName LIKE :term "
                . "OR username LIKE :term OR schoolID=:idTerm";
        try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);
                $likeTerm = '%' . $terms[0] . '%';
                $stmt->bindParam("term", $likeTerm);
		$stmt->bindParam("idTerm", $terms[0]);
		$stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($users);
                $db = null;
        } catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
    }
    if($numTerms == 2) {
        $sql = "SELECT fName, lName, username, organization  "
                . "FROM Users WHERE (fName LIKE :term1 AND lName LIKE :term2)"
                . "OR (fName LIKE :term2 AND lName LIKE :term1)";
        
        try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);  
                $likeTerm1 = '%' . $terms[0] . '%';
                $likeTerm2 = '%' . $terms[1] . '%';
		$stmt->bindParam("term1", $likeTerm1);
                $stmt->bindParam("term2", $likeTerm2);
		$stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($users);
                $db = null;
        } catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
    }
}

function search($term) {
    $terms = explode('|', $term);
    $newTerm = join(' ', $terms);
    $numTerms = count($terms);

    echo '[';
    if($numTerms == 1) {
        $sql = "SELECT fName, lName FROM Users WHERE fName LIKE :term "
                . "OR lName LIKE :term OR username LIKE :term";
        try {
            $db = dbconnect();
            $stmt = $db->prepare($sql);
            $likeTerm = '%' . $terms[0] . '%';
            $stmt->bindParam('term', $likeTerm);
            $stmt->execute();
            for($i = 0; $i < $stmt->rowCount(); $i++) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if($i == 0)
                    echo '{';
                else echo ',{';
                $userName = '"' . $user['fName'] . ' ' . $user['lName'] .'"';
                echo '"name":'.$userName.',"type":"user"}';
            }
            $db = null;
          
        } catch (PDOException $e) {
                error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
    if($numTerms == 2) {
        $sql = "SELECT fName, lName FROM Users "
                . "WHERE (fName LIKE :term1 AND lName LIKE :term2)"
                . "OR (fName LIKE :term2 AND lName LIKE :term1)";
        try {
            $db = dbconnect();
            $stmt = $db->prepare($sql);
            $likeTerm1 = '%' . $terms[0] . '%';
            $likeTerm2 = '%' . $terms[1] . '%';
            $stmt->bindParam("term1", $likeTerm1);
            $stmt->bindParam("term2", $likeTerm2);
            $stmt->execute();
            for($i = 0; $i < $stmt->rowCount(); $i++) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if($i == 0)
                    echo '{';
                else echo ',{';
                $userName = '"' . $user['fName'] . ' ' . $user['lName'] .'"';
                echo '"name":'.$userName.',"type":"user"}';
            }
            $db = null;
          
        } catch (PDOException $e) {
                error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
    
        
    $sql = "SELECT groupName FROM Groups WHERE groupName LIKE :term";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $likeTerm = '%' . $newTerm . '%';
        $stmt->bindParam('term', $likeTerm);
        $stmt->execute();
        for($i = 0; $i < $stmt->rowCount(); $i++) {
            $group = $stmt->fetch(PDO::FETCH_ASSOC);
            echo ',{"name":"'.$group['groupName'].'","type":"group"}';
        }
    } catch (PDOException $e) {
            error_log($e->getMessage(), 3, '/var/tmp/php.log');
            echo '{"error":{"text":'. $e->getMessage() .'}}';
    }

    $sql = "SELECT presName FROM Presentations WHERE presName LIKE :term";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $likeTerm = '%' . $newTerm . '%';
        $stmt->bindParam('term', $likeTerm);
        $stmt->execute();
        for($i = 0; $i < $stmt->rowCount(); $i++) {
            $pres = $stmt->fetch(PDO::FETCH_ASSOC);
            echo ',{"name":"'.$pres['presName'].'","type":"presentation"}';
        }
        $db = null;

    } catch (PDOException $e) {
            error_log($e->getMessage(), 3, '/var/tmp/php.log');
            echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    echo ']';
}

/* PRESENTATION FUNCTIONALITY */
function addPresentation() {
	error_log('addPresentation\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();

	$username = $_COOKIE['user'];
	$userId = getUserId($username);
	$rootURL = "/upload/" . $_COOKIE['user'] . "/";
	$groupId = 25;

	$presentation = json_decode($request->getBody());
	$sql = "INSERT INTO Presentations VALUES (DEFAULT, :title, :rootURL, :ownerId, :groupId, :presDate, :presTime, DEFAULT, DEFAULT)";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("title", $presentation->title);
		$stmt->bindParam("rootURL", $rootURL);
		$stmt->bindParam("ownerId", $userId);
		$stmt->bindParam("groupId", $groupId);
		$stmt->bindParam("presDate", $presentation->date);
		$stmt->bindParam("presTime", $presentation->time);
	    $stmt->execute();
		$db = null; 
		echo json_encode($presentation); 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}	
}

function getSlides($presID) {
        $sql = "SELECT rootURL, presName FROM Presentations WHERE presId=:presID";

        try {
            $db = dbconnect();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("presID", $presID);
            $stmt->execute();
            $pres = $stmt->fetch(PDO::FETCH_ASSOC);
			
            $url = $pres['rootURL'];
            $title = $pres['presName'];
            $dir = $url . "/" . $title;
            $urlTxt = $url; //Don't know what this is for
            $URLarray = array();
            $slidesARRAY = array();
            if (is_dir($dir)){
                if ($dh = opendir($dir)){
                    while (($file = readdir($dh)) !== false){
                        if($file == "." or $file == "..") continue;
                        $URLarray[] = $urlTxt . '/' . $file;
                        
                        $pattern = '/\d+/';
                        preg_match($pattern, $file, $matches);
						//error on below line - no idea why but it affects pulling slides from random presentations
                        $slideNum = $matches[0];
                        $slidesARRAY[] = $slideNum;
                        
                    }
                    closedir($dh);
                }
            }
            echo '{"numSlides":"' . count($URLarray) . '", "slides":{';
            for($i = 0; $i < count($URLarray); $i++) {
                if($i != 0)
                    echo ', ';
                echo '"' . $slidesARRAY[$i] . '":"' . $URLarray[$i] . '"';
            }
            echo '}}';        
            
            $db = null;
        } catch (PDOException $e) {
                error_log($e->getMessage(), 3, '/var/tmp/php.log');
                echo '{"error":"'. $e->getMessage() .'"}';
        }
}

function getCurrentSlide($presId) {
    $sql = "SELECT currSlide FROM Presentations WHERE presId = :presId";
    
    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("presId", $presId);
        $stmt->execute();
        $pres = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($pres);
        
        
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
	echo '{"error":"'. $e->getMessage() .'"}';
    }
}

function setCurrentSlide() {
        error_log('postUserInfo\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$user = json_decode($request->getBody());

	$sql = "UPDATE Presentations SET currSlide = :currSlide WHERE presId = :presId";

        
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("currSlide", $user->currSlide);
		$stmt->bindParam("presId", $user->presId);
                $stmt->execute();
		$db = null;  
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
}

function getPresentations($username) {
    $sql = "SELECT userId FROM Users WHERE username = :username";
    $presSql = "SELECT presId, presName FROM Presentations WHERE ownerId = :userId";
    
    try {
            $db = dbconnect();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("username", $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $userId = $user['userId'];
            
            $stmt = $db->prepare($presSql);
            $stmt->bindParam("userId", $userId);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $presentations = $stmt->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($presentations);
            }
            else
                
            $db = null;
            
            
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
	echo '{"error":"'. $e->getMessage() .'"}';
    }
}

function deletePresentation() {
	error_log('deletePresentation\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();

	$presInfo = json_decode($request->getBody());
	$username = $_COOKIE['user'];
	$userId = getUserId($username);
	$title = $presInfo->title;
	//$FileParser = new FileParser();
	//$FileParser->deletePresentation($title);

	$sql = "DELETE FROM Presentations WHERE presName = :title AND ownerId = :userId";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("title", $title);
		$stmt->bindParam("userId", $userId);
	    $stmt->execute();
		$db = null; 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}	
}

//set current Presentation ID in cookie
function setPresId() {
	error_log('setPresId\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();

	$presInfo = json_decode($request->getBody());

	setcookie("pres", $presInfo->presID, time()+10000, '/');	
	echo($_COOKIE['pres']);
}
function getPresInfo() {
	error_log('deletePresentation\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	
	$presID = $_COOKIE['pres'];
	$sql = "SELECT * FROM Presentations WHERE presId = :presId";

	try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("presId", $presID);
        $stmt->execute();
        $pres = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($pres);
        
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":"'. $e->getMessage() .'"}';
    }
}


/* GROUP FUNCTIONALITY */
function getGroupMembers($groupName) { //doesn't work
	$sql = "SELECT * FROM Group_Users 
			INNER JOIN Groups
			ON Groups.groupId = Group_Users.groupId
			WHERE Groups.groupName = :groupName";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("groupName", $groupName);
		$stmt->execute();
		if($stmt->rowCount() >= 1) { 
			$groupMembers = $stmt->fetch_all;
			echo json_encode($groupMembers);
		}
		else echo '{"error": true}';
		$db = null;
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":"'. $e->getMessage() .'"}';
	}
}
function createGroup() {
	error_log('createGroup\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$group = json_decode($request->getBody());
	$sqlGroup = "INSERT INTO Groups VALUES (DEFAULT, :groupName,"
                . " :ownerId, :code)";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sqlGroup);   
		$stmt->bindParam("groupName", $group->groupName);
		$stmt->bindParam("ownerId", $group->ownerId);
		$stmt->bindParam("Code", $group->Code);
	    $stmt->execute();
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":"'. $e->getMessage() .'"}';
	}	

	$sqlGroupId = "SELECT groupId FROM Groups WHERE groupName = :groupName";
	$groupId = "";
	try {
		$stmt = $db->prepare($sqlGroupId);
		$stmt->bindParam("groupName", $group->groupName);
		$stmt->execute();
		$group = $stmt->fetch(PDO::FETCH_ASSOC);
                $groupId = $group['groupId'];
                
	}

	/* This doesn't work, no idea how to do this as of yet
	$sqlGroupUsers = "INSERT INTO Group_Users VALUES ();";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("rootURL", $presentation->rootURL);
		$stmt->bindParam("sessId", $presentation->sessId);
		$stmt->bindParam("username", $presentation->username);
	    $stmt->execute();
		$db = null; 
		echo json_encode($presentation); */
	catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
        ;
}
function addToGroup() {
	//Add USERS to a group
}
function deleteFromGroup() {
	//delete USERS from a group
}
function deleteGroup() {
	//delete ENTIRE group
}

?>
