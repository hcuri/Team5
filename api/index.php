<?php

require 'Slim/Slim.php';
require_once('../php/lib.php');
require '../php/password.php';
require '../FileParser/FileParser.php';

$app = new Slim();

//User functions
$app->get('/verify/:username/:pass', 'verifyRegistered');
$app->get('/registered/:email/:username', 'checkIfRegistered');
$app->get('/logout', 'logoutUser');
$app->get('/getUserInfo', 'getUserInfo');
$app->get('/searchUsers/:term', 'searchUsers');
$app->get('/search/:term', 'search');
$app->post('/postUserInfo', 'postUserInfo');
$app->post('/register', 'registerUser');
$app->post('/email', 'email');

//Presentation functions
$app->post('/addPresentation', 'addPresentation');
$app->post('/updatePresentation', 'updateGroupId');
$app->post('/finishPresentation', 'finishPresentation');
$app->get('/getPresentations/:username', 'getPresentations');
$app->get('/getPastPresentations/:username', 'getPastPresentations');
$app->get('/getUpcomingPresentations/:username', 'getUpcomingPresentations');
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
$app->get('/getGroups', 'getGroups');

//Poll functions
$app->post('/createPoll', 'createPoll');
$app->post('/submitResponse', 'submitResponse');
$app->get('/getPollInfo/:presId/:slideNum', 'getPollInfo');
$app->get('/getPollResults/:presId/:slideNum', 'getPollResults');


$app->run();

/* USER FUNCTIONALITY */

function verifyRegistered($username, $password) {
    $sql = "SELECT * FROM Users WHERE username=:username";
    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("username", $username);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $userInfo['password'])) {
                echo '{"registered": true}';
                setcookie("user", $username, time() + 7200, '/');
            } else
                echo '{"registered": false}';
        } else
            echo '{"registered": false}';
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
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
        if ($stmt->rowCount() > 0)
            echo '{"email": true,';
        else
            echo '{"email": false,';

        // Check username
        $stmt = $db->prepare($sqlUsername);
        $stmt->bindParam("username", $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
            echo '"username": true}';
        else
            echo '"username": false}';
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function registerUser() {
    error_log('addUser' . "\n", 3, '/var/tmp/php.log');
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
        setcookie("user", $user->username, time() + 3600, '/');

        echo json_encode($user);
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
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
        if ($stmt->rowCount() == 1) {
            $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($userInfo);
        } else {
            echo $errorInfo;
        }
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function postUserInfo() {
    error_log('postUserInfo' . "\n", 3, '/var/tmp/php.log');
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
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function searchUsers($term) {
    $terms = explode('-', $term);
    $numTerms = count($terms);

    if ($numTerms == 1) {
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
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, '/var/tmp/php.log');
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    if ($numTerms == 2) {
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
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, '/var/tmp/php.log');
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
}

function search($term) {
    $terms = explode('|', $term);
    $newTerm = join(' ', $terms);
    $numTerms = count($terms);

    echo '[';
    if ($numTerms == 1) {
        $sql = "SELECT fName, lName FROM Users WHERE fName LIKE :term "
                . "OR lName LIKE :term OR username LIKE :term";
        try {
            $db = dbconnect();
            $stmt = $db->prepare($sql);
            $likeTerm = '%' . $terms[0] . '%';
            $stmt->bindParam('term', $likeTerm);
            $stmt->execute();
            for ($i = 0; $i < $stmt->rowCount(); $i++) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($i == 0)
                    echo '{';
                else
                    echo ',{';
                $userName = '"' . $user['fName'] . ' ' . $user['lName'] . '"';
                echo '"name":' . $userName . ',"type":"user"}';
            }
            $db = null;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, '/var/tmp/php.log');
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }
    if ($numTerms == 2) {
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
            for ($i = 0; $i < $stmt->rowCount(); $i++) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($i == 0)
                    echo '{';
                else
                    echo ',{';
                $userName = '"' . $user['fName'] . ' ' . $user['lName'] . '"';
                echo '"name":' . $userName . ',"type":"user"}';
            }
            $db = null;
        } catch (PDOException $e) {
            error_log($e->getMessage(), 3, '/var/tmp/php.log');
            echo '{"error":{"text":' . $e->getMessage() . '}}';
        }
    }


    $sql = "SELECT groupName FROM Groups WHERE groupName LIKE :term";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $likeTerm = '%' . $newTerm . '%';
        $stmt->bindParam('term', $likeTerm);
        $stmt->execute();
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            $group = $stmt->fetch(PDO::FETCH_ASSOC);
            echo ',{"name":"' . $group['groupName'] . '","type":"group"}';
        }
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

    $sql = "SELECT presName FROM Presentations WHERE presName LIKE :term";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $likeTerm = '%' . $newTerm . '%';
        $stmt->bindParam('term', $likeTerm);
        $stmt->execute();
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            $pres = $stmt->fetch(PDO::FETCH_ASSOC);
            echo ',{"name":"' . $pres['presName'] . '","type":"presentation"}';
        }
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
    echo ']';
}

function email() {
    error_log('email' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $email = json_decode($request->getBody());
    $sql = "SELECT email FROM Users WHERE username=:username";
    $from = 'no-reply@upresent.org';
    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('username', $email->name);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $uEmail = $stmt->fetch(PDO::FETCH_ASSOC);
            $from = $uEmail['email'];
        }
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }

    $to = 'tyler.george@live.com'; //admin@upresent.org';
    $subject = $email->subject;
    $message = $email->message;
    $headers = 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    if (mail($to, $subject, $message, $headers))
        echo '"sent":true';
    else
        echo '"sent":false';
}

/* PRESENTATION FUNCTIONALITY */

function addPresentation() {
    error_log('addPresentation' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    
    $username = $_COOKIE['user'];
    $userId = getUserId($username);
    $rootURL = "upload/" . $_COOKIE['user'] . "/";
    $groupId = 0;
    $presentation = json_decode($request->getBody());

    $sqlCheck = "SELECT * FROM Presentations WHERE presName = :title AND ownerId = :ownerId";
    $sql = "INSERT INTO Presentations VALUES (DEFAULT, :title, :rootURL, :ownerId, :groupId, :presDate, :presTime, DEFAULT, DEFAULT)";
    $sqlId = "SELECT presId FROM Presentations WHERE presName = :title AND ownerId = :ownerId";

    
    
    try {
        $db = dbconnect();

        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->bindParam("title", $presentation->title);
        $stmtCheck->bindParam("ownerId", $userId);
        $stmtCheck->execute();
        if ($stmtCheck->rowCount() > 0) {
            echo '{"error":"true"}';
            return;
        }
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam("title", $presentation->title);
        $stmt->bindParam("rootURL", $rootURL);
        $stmt->bindParam("ownerId", $userId);
        $stmt->bindParam("groupId", $groupId);
        $stmt->bindParam("presDate", $presentation->date);
        $stmt->bindParam("presTime", $presentation->time);
        $stmt->execute();

        $stmtId = $db->prepare($sqlId);
        $stmtId->bindParam("title", $presentation->title);
        $stmtId->bindParam("ownerId", $userId);
        $stmtId->execute();
        $id = $stmtId->fetch(PDO::FETCH_ASSOC);
        setcookie("pres", $id['presId'], time() + 3600, '/');

        $db = null;
        echo '{"error":"false"}';
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function updateGroupId() {
    error_log('updateGroupId' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $id = json_decode($request->getBody());

    $ownerId = idFromUsername($_COOKIE['user']);
    $groupName = $id->groupName;
    $sqlGroupId = "SELECT groupId FROM Groups WHERE groupName=:groupName AND ownerId=:ownerId";
    $sqlUpdate = "UPDATE Presentations SET groupId = :groupId WHERE ownerId=:ownerId AND presName=:presName";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sqlGroupId);
        $stmt->bindParam("groupName", $groupName);
        $stmt->bindParam("ownerId", $ownerId);
        $stmt->execute();
        $group = $stmt->fetch(PDO::FETCH_ASSOC);
        $groupId = $group['groupId'];

        $stmt = $db->prepare($sqlUpdate);
        $stmt->bindParam("ownerId", $ownerId);
        $stmt->bindParam("groupId", $groupId);
        $stmt->bindParam("presName", $id->presName);
        $stmt->execute();

        echo json_encode($id);
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function finishPresentation() {
    error_log('finishPres' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $id = json_decode($request->getBody());
    
    $sqlCheck = "SELECT alreadyPresented FROM Presentations WHERE presId = :presId";
    $sql = "UPDATE Presentations SET alreadyPresented = '1' WHERE presId = :presId";
    
    try {
        $db = dbconnect();
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->bindParam("presId", $id->presId);
        $stmtCheck->execute();
        $presented = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if($presented['alreadyPresented'] == 0) {
            $stmt = $db->prepare($sql);
            //$presented = 1;
            //$stmt->bindParam("fin", $presented);
            $stmt->bindParam("presId", $id->presId);
            $stmt->execute();
        
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        }
        else 
            echo '{"alreadyPresented":"true"}';
        
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
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
        $dir = "../" . $url . $title . "/";
        //$urlTxt = $url; //Don't know what this is for
        $URLarray = array();
        $slidesARRAY = array();
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file == "." or $file == "..")
                        continue;
                    $URLarray[] = $url . $title . "/" . $file;

                    $pattern = '/\d+/';
                    preg_match($pattern, $file, $matches);
                    //error on below line - no idea why but it affects pulling slides from random presentations
                    //--ANSWER: could be that the file names don't have a number in them...
                    if (!empty($matches)) {
                        $slideNum = $matches[0];
                        $slidesARRAY[] = $slideNum;
                    } else {
                        $slideNum = 0;
                        $slidesARRAY[] = $slideNum;
                    }
                }
                closedir($dh);
            }
        }
        echo '{"numSlides":"' . count($URLarray) . '", "slides":{';
        for ($i = 0; $i < count($URLarray); $i++) {
            if ($i != 0)
                echo ', ';
            echo '"' . $slidesARRAY[$i] . '":"' . $URLarray[$i] . '"';
        }
        echo '}}';

        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
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
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function setCurrentSlide() {
    error_log('postUserInfo' . "\n", 3, '/var/tmp/php.log');
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
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function getPresentations($username) {
    $userId = idFromUsername($username);
    $presSql = "SELECT presId, presName FROM Presentations WHERE ownerId = :userId";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($presSql);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $presentations = $stmt->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($presentations);
        }
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function getPastPresentations($username) { //doesn't work yet
    $userId = idFromUsername($username);

    $groupSql = "SELECT groupId FROM Group_Users WHERE userId = :userId";
    $presSql = "SELECT presId, presName, ownerId, presDate, alreadyPresented FROM Presentations "
            . "WHERE groupId = :groupId";
    $presenterSql = "SELECT fName, lName FROM Users WHERE userId = :ownerId";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($groupSql);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        echo '[';
        $echoedPresentations = 0;
        if ($stmt->rowCount() > 0) {
            for ($i = 0; $i < $stmt->rowCount(); $i++) {
                $group = $stmt->fetch(PDO::FETCH_ASSOC);
                $presStmt = $db->prepare($presSql);
                $presStmt->bindParam("groupId", $group['groupId']);
                $presStmt->execute();
                for ($j = 0; $j < $presStmt->rowCount(); $j++) {
                    $presentation = $presStmt->fetch(PDO::FETCH_ASSOC);
                    $presented = $presentation['alreadyPresented'];
                    if ($presented == 1) {
                        $ownerStmt = $db->prepare($presenterSql);
                        $ownerStmt->bindParam("ownerId", $presentation['ownerId']);
                        $ownerStmt->execute();
                        $owner = $ownerStmt->fetch(PDO::FETCH_ASSOC);
                        $ownerName = $owner['fName'] . ' ' . $owner['lName'];
                        if ($echoedPresentations == 0)
                            echo '{';
                        else
                            echo ',{';
                        echo '"presId":"' . $presentation['presId'] . '", "presName":"'
                        . $presentation['presName'] . '", "ownerName":"' . $ownerName
                        . '", "presDate":"' . $presentation['presDate'] . '"}';
                        $echoedPresentations++;
                    } else
                        continue;
                }
            }
        }
        echo ']';
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function getUpcomingPresentations($username) { 
    $userId = idFromUsername($username);

    $groupSql = "SELECT groupId FROM Group_Users WHERE userId = :userId";
    $presSql = "SELECT presId, presName, ownerId, presDate, alreadyPresented FROM Presentations "
            . "WHERE groupId = :groupId";
    $presenterSql = "SELECT fName, lName FROM Users WHERE userId = :ownerId";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($groupSql);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        echo '[';
        $echoedPresentations = 0;
        if ($stmt->rowCount() > 0) {
            for ($i = 0; $i < $stmt->rowCount(); $i++) {
                $group = $stmt->fetch(PDO::FETCH_ASSOC);
                $presStmt = $db->prepare($presSql);
                $presStmt->bindParam("groupId", $group['groupId']);
                $presStmt->execute();
                for ($j = 0; $j < $presStmt->rowCount(); $j++) {
                    $presentation = $presStmt->fetch(PDO::FETCH_ASSOC);
                    $presented = $presentation['alreadyPresented'];
                    if ($presented == 0) {
                        $ownerStmt = $db->prepare($presenterSql);
                        $ownerStmt->bindParam("ownerId", $presentation['ownerId']);
                        $ownerStmt->execute();
                        $owner = $ownerStmt->fetch(PDO::FETCH_ASSOC);
                        $ownerName = $owner['fName'] . ' ' . $owner['lName'];
                        if ($echoedPresentations == 0)
                            echo '{';
                        else
                            echo ',{';
                        echo '"presId":"' . $presentation['presId'] . '", "presName":"'
                        . $presentation['presName'] . '", "ownerName":"' . $ownerName
                        . '", "presDate":"' . $presentation['presDate'] . '"}';
                        $echoedPresentations++;
                    } else
                        continue;
                }
            }
        }
        echo ']';
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function deletePresentation() {
    error_log('deletePresentation' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();

    $presInfo = json_decode($request->getBody());
    $username = $_COOKIE['user'];
    $userId = getUserId($username);
    $title = $presInfo->title;
    $FileParser = new FileParser();
    $FileParser->deletePresentation($title);
    $sqlPresId = "SELECT presId FROM Presentations WHERE presName = :title AND ownerId = :userId";
    $sqlPollCheck = "SELECT pollId FROM Poll WHERE presId = :presId";
    $sqlDelPollOps = "DELETE FROM Poll_Options WHERE pollId = :pollId";
    $sqlDelPoll = "DELETE FROM Poll WHERE presId = :presId";
    $sql = "DELETE FROM Presentations WHERE presName = :title AND ownerId = :userId";
    
    try {
        $db = dbconnect();
        $stmtPresId = $db->prepare($sqlPresId);
        $stmtPresId->bindParam("title", $title);
        $stmtPresId->bindParam("userId", $userId);
        $stmtPresId->execute();
        $pres = $stmtPresId->fetch(PDO::FETCH_ASSOC);
        $presId = $pres['presId'];
        
        $stmtPollCheck = $db->prepare($sqlPollCheck);
        $stmtPollCheck->bindParam("presId", $presId);
        $stmtPollCheck->execute();
        if($stmtPollCheck->rowCount() > 0) {
            for($i = 0; $i < $stmtPollCheck->rowCount(); $i++) {
                $poll = $stmtPollCheck->fetch(PDO::FETCH_ASSOC);
                $pollId = $poll['pollId'];
                
                $stmtDelPollOps = $db->prepare($sqlDelPollOps);
                $stmtDelPollOps->bindParam("pollId", $pollId);
                $stmtDelPollOps->execute();
            
                $stmtDelPoll = $db->prepare($sqlDelPoll);
                $stmtDelPoll->bindParam("presId", $presId);
                $stmtDelPoll->execute();
            }
        }
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam("title", $title);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

//set current Presentation ID in cookie
function setPresId() {
    error_log('setPresId' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();

    $presInfo = json_decode($request->getBody());

    setcookie("pres", $presInfo->presID, time() + 10000, '/');
    echo($_COOKIE['pres']);
}

function getPresInfo() {
    error_log('getPresInfo' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();

    $presID = $_COOKIE['pres'];
    $sql = "SELECT Presentations.*, Users.fName, Users.lName"
            . " FROM Presentations INNER JOIN Users ON Presentations.ownerId = Users.userId"
            . " WHERE presId = :presId";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("presId", $presID);
        $stmt->execute();
        $pres = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($pres);
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
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
        if ($stmt->rowCount() >= 1) {
            $groupMembers = $stmt->fetch_all;
            echo json_encode($groupMembers);
        } else
            echo '{"error": true}';
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function createGroup() {
    error_log('createGroup' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $group = json_decode($request->getBody());
    $ownerId = idFromUsername($_COOKIE['user']);
    $sqlGroup = "INSERT INTO Groups VALUES (DEFAULT, :groupName,"
            . " :ownerId)";
    $sqlCheck = "SELECT * FROM Groups WHERE groupName=:groupName AND ownerId=:ownerId";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sqlCheck);
        $stmt->bindParam("groupName", $group->groupName);
        $stmt->bindParam("ownerId", $ownerId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo 'group_exists';
            return;
        }


        $stmt = $db->prepare($sqlGroup);
        $stmt->bindParam("groupName", $group->groupName);
        $stmt->bindParam("ownerId", $ownerId);
        $stmt->execute();
        echo json_encode($group);
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function addToGroup() {
    error_log('addToGroup' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $user = json_decode($request->getBody());

    $ownerUsername = $_COOKIE['user'];
    $ownerId = idFromUsername($ownerUsername);
    $sqlGroup = "SELECT groupId FROM Groups WHERE groupName=:groupName AND ownerId=:ownerId";

    $userId = idFromUsername($user->username);
    $sqlCheck = "SELECT * FROM Group_Users WHERE groupId = :groupId AND userId = :userId";
    $sqlUser = "INSERT INTO Group_Users VALUES (:groupId, :userId)";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sqlGroup);
        $stmt->bindParam("groupName", $user->groupName);
        $stmt->bindParam("ownerId", $ownerId);
        $stmt->execute();
        $group = $stmt->fetch(PDO::FETCH_ASSOC);
        $groupId = $group['groupId'];

        $stmt = $db->prepare($sqlCheck);
        $stmt->bindParam("groupId", $groupId);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
            return;

        $stmt = $db->prepare($sqlUser);
        $stmt->bindParam("groupId", $groupId);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        echo json_encode($user);
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function deleteFromGroup() {
    $request = Slim::getInstance()->request();
    $user = json_decode($request->getBody());


    $ownerUsername = $_COOKIE['user'];
    $ownerId = idFromUsername($ownerUsername);
    $sqlGroup = "SELECT groupId FROM Groups WHERE groupName=:groupName AND ownerId=:ownerId";

    $userId = idFromUsername($user->username);
    $sqlUser = "DELETE FROM Group_Users "
            . "WHERE groupId=:groupId AND userId=:userId";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sqlGroup);
        $stmt->bindParam("groupName", $user->groupName);
        $stmt->bindParam("ownerId", $ownerId);
        $stmt->execute();
        $group = $stmt->fetch(PDO::FETCH_ASSOC);
        $groupId = $group['groupId'];

        $stmt = $db->prepare($sqlUser);
        $stmt->bindParam("groupId", $groupId);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        echo json_encode($user);
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function deleteGroup() {
    error_log('deleteGroup' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $group = json_decode($request->getBody());

    $ownerUsername = $_COOKIE['user'];
    $ownerId = idFromUsername($ownerUsername);
    $sqlGroup = "SELECT groupId FROM Groups WHERE groupName=:groupName AND ownerId=:ownerId";

    $sqlUsers = "DELETE FROM Group_Users WHERE groupId=:groupId";
    $sqlDelete = "DELETE FROM Groups WHERE groupName=:groupName AND ownerId=:ownerId";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sqlGroup);
        $stmt->bindParam("groupName", $group->groupName);
        $stmt->bindParam("ownerId", $ownerId);
        $stmt->execute();
        $groupx = $stmt->fetch(PDO::FETCH_ASSOC);
        $groupId = $groupx['groupId'];

        $stmt = $db->prepare($sqlUsers);
        $stmt->bindParam("groupId", $groupId);
        $stmt->execute();

        $stmt = $db->prepare($sqlDelete);
        $stmt->bindParam("groupName", $group->groupName);
        $stmt->bindParam("ownerId", $ownerId);
        $stmt->execute();
        echo json_encode($group);
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function getGroups() {
    $ownerId = idFromUsername($_COOKIE['user']);
    $sql = "SELECT groupId, groupName FROM Groups WHERE ownerId=:ownerId";
    $sqlGroup = "SELECT userId FROM Group_Users WHERE groupId=:groupId";
    $sqlName = "SELECT fName, lName, username FROM Users WHERE userId=:userId";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam('ownerId', $ownerId);
        $stmt->execute();
        echo '[';
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            $group = $stmt->fetch(PDO::FETCH_ASSOC);
            $groupId = $group['groupId'];
            if ($i == 0)
                echo '{';
            else
                echo ',{';
            echo '"groupName":"' . $group['groupName'] . '", ';
            $stmtUsers = $db->prepare($sqlGroup);
            $stmtUsers->bindParam('groupId', $groupId);
            $stmtUsers->execute();
            echo '"numUsers":"' . $stmtUsers->rowCount() . '", "users":{';
            for ($j = 0; $j < $stmtUsers->rowCount(); $j++) {
                $group_user = $stmtUsers->fetch(PDO::FETCH_ASSOC);
                $userId = $group_user['userId'];
                $stmtName = $db->prepare($sqlName);
                $stmtName->bindParam('userId', $userId);
                $stmtName->execute();
                for ($k = 0; $k < $stmtName->rowCount(); $k++) {
                    $user = $stmtName->fetch(PDO::FETCH_ASSOC);
                    $name = $user['fName'] . " " . $user['lName'];
                    if ($j == 0)
                        echo '"' . $j . '":{';
                    else
                        echo ', "' . $j . '":{';
                    echo '"name":"' . $name . '", "username":"' . $user['username'] . '"}';
                }
            }
            echo '}}';
        }
        echo ']';
        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

/* POLL Functionality */

function createPoll() {
    error_log('addPoll' . "\n", 3, 'var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $poll = json_decode($request->getBody());

    $optionNums = ['A', 'B', 'C', 'D', 'E', 'F'];

    $sqlNew = "INSERT INTO Poll VALUES (DEFAULT, :presId, :slideNum, :question, :numOptions)";
    $sqlUpdate = "UPDATE Poll SET question = :question, numOptions = :numOptions WHERE pollId = :pollId";
    $sqlPollId = "SELECT pollId FROM Poll WHERE presId = :presId AND slideNum = :slideNum";
    $sqlOp = "INSERT INTO Poll_Options VALUES (:pollId, :optionNum, :optionText, DEFAULT)";
    $sqlOpUp = "UPDATE Poll_Options SET optionText = :optionText WHERE pollId = :pollId";
    $sqlCheck = "SELECT * FROM Poll WHERE presId = :presId AND slideNum = :slideNum";

    try {
        $db = dbconnect();

        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->bindParam("presId", $poll->presId);
        $stmtCheck->bindParam("slideNum", $poll->slide);
        $stmtCheck->execute();
        if ($stmtCheck->rowCount() > 0) {

            $stmtNew = $db->prepare($sqlNew);
            $stmtNew->bindParam("presId", $poll->presId);
            $stmtNew->bindParam("slideNum", $poll->slide);
            $stmtNew->bindParam("question", $poll->question);
            $stmtNew->bindParam("numOptions", $poll->numOptions);
            $stmtNew->execute();
            
            $stmtPollId = $db->prepare($sqlPollId);
            $stmtPollId->bindParam("presId", $poll->presId);
            $stmtPollId->bindParam("slideNum", $poll->slide);
            $stmtPollId->execute();
            $pollId = $stmtPollId->fetch(PDO::FETCH_ASSOC);
            
            error_log("test", 3, '/var/tmp/php.log');
            for ($i = 0; $i < $poll->numOptions; $i++) {
                $stmtOptions = $db->prepare($sqlOp);
                $stmtOptions->bindParam("pollId", $pollId['pollId']);
                $stmtOptions->bindParam("optionNum", $optionNums[$i]);
                $stmtOptions->bindParam("optionText", $pollId->options[$optionNums[$i]]);
                $stmtOptions->execute();
            }
        }
        else {
            $pollId = $stmtCheck->fetch(PDO::FETCH_ASSOC);
            
            $stmtUpdate = $db->prepare($sqlUpdate);
            $stmtUpdate->bindParam("question", $poll->question);
            $stmtUpdate->bindParam("numOptions", $poll->numOptions);
            $stmtUpdate->bindParam("pollId", $pollId['pollId']);
            $stmtUpdate->execute();
            
            for($i = 0; $i < $poll->numOptions; $i++) {
                $stmtOpUpdate = $db->prepare($sqlOpUp);
                $stmtOpUpdate->bindParam("optionText", $poll->options[$optionNums[$i]]);
                $stmtOpUpdate->bindParam("pollId", $pollId['pollId']);
                $stmtOpUpdate->execute();
            }
        }

        $db = null;
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function submitResponse () {
    error_log('submitResponse' . "\n", 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $response = json_decode($request->getBody());
    
    $sqlPollId = "SELECT pollId FROM Poll WHERE presId = :presId AND slideNum = :slide";
    $sqlOpRes = "SELECT option_results FROM Poll_Options WHERE pollId = :pollId AND option_num = :choice";
    $sql = "UPDATE Poll_Options SET option_results = :optionResults WHERE pollId = :pollId AND option_num = :choice";

    try {
        $db = dbconnect();
        $stmtPoll = $db->prepare($sqlPollId);
        $stmtPoll->bindParam("presId", $response->presId);
        $stmtPoll->bindParam("slide", $response->currSlide);
        $stmtPoll->execute();
        $pollId = $stmtPoll->fetch(PDO::FETCH_ASSOC);
        
        $stmtOpRes = $db->prepare($sqlOpRes);
        $stmtOpRes->bindParam("pollId", $pollId['pollId']);
        $stmtOpRes->bindParam("choice", $response->response);
        $stmtOpRes->execute();
        $opRes = $stmtOpRes->fetch(PDO::FETCH_ASSOC);
        $result = $opRes['option_results'];
        $result++;
        
        $stmt = $db->prepare($sql);
        $stmt->bindParam("optionResults", $result);
        $stmt->bindParam("pollId", $pollId['pollId']);
        $stmt->bindParam("choice", $response->response);
        $stmt->execute();
        
        $db = null;
        
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

function getPollInfo($presId, $slide) {
    $sqlPollId = "SELECT pollId FROM Poll WHERE presId = :presId AND slideNum = :slide";
    $sqlPollQuestion = "SELECT question FROM Poll WHERE pollId = :pollId AND slideNum = :slide";
    $sqlPollInfo = "SELECT option_num, option_text FROM Poll_Options WHERE pollId = :pollId";
    
    
    try {
        $db = dbconnect();
        $stmtPollId = $db->prepare($sqlPollId);
        $stmtPollId->bindParam("presId", $presId);
        $stmtPollId->bindParam("slide", $slide);
        $stmtPollId->execute();
        $pollId = $stmtPollId->fetch(PDO::FETCH_ASSOC);
        $pollId = $pollId['pollId'];

        $stmtPollQuestion = $db->prepare($sqlPollQuestion);
        $stmtPollQuestion->bindParam("pollId", $pollId);
        $stmtPollQuestion->bindParam("slide", $slide);
        $stmtPollQuestion->execute();
        $pollQuestion = $stmtPollQuestion->fetch(PDO::FETCH_ASSOC);
        $pollQuestion = $pollQuestion['question'];
        $pollQuestion = json_encode($pollQuestion);

        $stmtPollInfo = $db->prepare($sqlPollInfo);
        $stmtPollInfo->bindParam("pollId", $pollId);
        $stmtPollInfo->execute();
        $pollInfo = $stmtPollInfo->fetchAll(PDO::FETCH_OBJ);
        $pollInfo = json_encode($pollInfo);

        $pollInfo = str_replace("[", "", $pollInfo);
        $pollInfo = str_replace("]", "", $pollInfo);

        $poll = '[{"question":' . $pollQuestion . '},' . $pollInfo . ']';

        echo $poll;
        $db = null;

    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
    
}

function getPollResults($presId, $slide) {
    $sqlPollId = "SELECT pollId FROM Poll WHERE presId = :presId AND slideNum = :slide";
    $sql = "SELECT option_num, option_results FROM Poll_Options WHERE pollId = :pollId";
    
    
    try {
        $db = dbconnect();
        $stmtPollId = $db->prepare($sqlPollId);
        $stmtPollId->bindParam("presId", $presId);
        $stmtPollId->bindParam("slide", $slide);
        $stmtPollId->execute();
        $pollId = $stmtPollId->fetch(PDO::FETCH_ASSOC);
		$pollId = $pollId['pollId'];
		
        $stmt = $db->prepare($sql);
        $stmt->bindParam("pollId", $pollId);
        $stmt->execute();
        $pollResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($pollResults);
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
    
}

function idFromUsername($username) {
    $sql = "SELECT userId FROM Users WHERE username=:username";

    try {
        $db = dbconnect();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("username", $username);
        $stmt->execute();
        $userID = $stmt->fetch(PDO::FETCH_ASSOC);
        $db = null;
        return $userID['userId'];
    } catch (PDOException $e) {
        error_log($e->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":"' . $e->getMessage() . '"}';
    }
}

?>
