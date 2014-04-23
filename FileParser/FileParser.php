<?php

require_once('php/lib.php');

class FileParser {

    function modifyPresentation($files, $title) {
        $userFolder = "upload/" . $_COOKIE['user'];
        if (!is_dir($userFolder)) {
            mkdir($userFolder);
            
        }

        $folder = "upload/" . $_COOKIE['user'] . "/" . $title;
        $uPresentExists = false;
        if (is_dir($folder))
            $uPresentExists = true;

        rrmdir($folder, $uPresentExists);
//rmdir("upload/" . $_COOKIE['user'] . "/hi");
        mkdir($folder);
        


        if (strtolower($_SERVER['REQUEST_METHOD']) == 'post' && !empty($_FILES)) {

            $username = $_COOKIE['user'];
            $userId = getUserId($username);
            try {
                $sql = "SELECT presId 
						FROM Presentations 
						WHERE presName = :title  
						AND ownerId = :userId;";
                $db = dbconnect();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("title", $title);
                $stmt->bindParam("userId", $userId);
                $stmt->execute();
                $pres = $stmt->fetch(PDO::FETCH_ASSOC);
                $presId = $pres['presId'];
            } catch (PDOException $e) {
                error_log($e->getMessage(), 3, '/var/tmp/php.log');
                echo '{"error":{"text":' . $e->getMessage() . '}}';
            }

            foreach ($_FILES["files"]['tmp_name'] as $index => $tmpName) {

                if ((($_FILES["files"]["type"][$index] == "image/gif") || ($_FILES["files"]["type"][$index] == "image/jpeg") || ($_FILES["files"]["type"][$index] == "image/jpg") || ($_FILES["files"]["type"][$index] == "image/pjpeg") || ($_FILES["files"]["type"][$index] == "image/x-png") || ($_FILES["files"]["type"][$index] == "image/png")) && ($_FILES["files"]["size"][$index] < 200000000000)) {
                    //echo "Upload: " . $_FILES["files"]['name'][$index] . "<br>";
                    //echo "Type: " . $_FILES["files"]['type'][$index] . "<br>";
                    //echo "Size: " . ($_FILES["files"]['size'][$index] / 1024) . " kB<br>";
                    //echo "Temp file: " . $_FILES["files"]['tmp_name'][$index] . "<br>";
//                    else {
//                    	mkdir($folder, 0777);
//                    }

                    move_uploaded_file($_FILES["files"]["tmp_name"][$index], $folder . "/" . $_FILES["files"]["name"][$index]);
                }
            }
        }
    }

    function deletePresentation($title) {
        $folder = "upload/" . $_COOKIE['user'] . "/" . $title;
        rrmdir($folder, true);
    }

    
}
function rrmdir($dir, $exists) {
    error_log("rrmdir\n", 3, "/var/tmp/php.log");
    rmdir("upload/tbgeorge/test");
    error_log($dir, 3, "/var/tmp/php.log");
    if (is_dir($dir)) { // and $exists) {
        error_log($dir, 3, "/var/tmp/php.log");
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file == "." or $file == "..")
                    continue;

                unlink($dir . "/" . $file);
                //$file = $dir."/".$object;
                error_log($file, 3, "/var/tmp/php.log");
            }
        }
        rmdir($dir);
    }
}
?>