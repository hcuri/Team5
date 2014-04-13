<?php

require_once('php/lib.php');

class FileParser {
	function modifyPresentation($files, $title) {
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post' && !empty($_FILES)) {

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
			} catch(PDOException $e) {
				error_log($e->getMessage(), 3, '/var/tmp/php.log');
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}

  			foreach($_FILES["files"]['tmp_name'] as $index => $tmpName) {

    			if ((($_FILES["files"]["type"][$index] == "image/gif")
      				|| ($_FILES["files"]["type"][$index] == "image/jpeg")
      				|| ($_FILES["files"]["type"][$index] == "image/jpg")
      				|| ($_FILES["files"]["type"][$index] == "image/pjpeg")
      				|| ($_FILES["files"]["type"][$index] == "image/x-png")
      				|| ($_FILES["files"]["type"][$index] == "image/png"))
      				&& ($_FILES["files"]["size"][$index] < 200000000000))
    			{
      				echo "Upload: " . $_FILES["files"]['name'][$index] . "<br>";
      				echo "Type: " . $_FILES["files"]['type'][$index] . "<br>";
      				echo "Size: " . ($_FILES["files"]['size'][$index] / 1024) . " kB<br>";
      				echo "Temp file: " . $_FILES["files"]['tmp_name'][$index] . "<br>";

      				$folder = "upload/" . $_COOKIE['user'] . "/" . $title;
      				if(is_dir($folder)) {
        				rmdir($folder);
        				mkdir($folder, 0700);
        			}
        			else 
      					mkdir($folder, 0700);

        			move_uploaded_file($_FILES["files"]["tmp_name"][$index], $folder . "/" . $_FILES["files"]["name"][$index]);
    			}
    			else {
    				//Error handling
    			}
  			}
		}
	}
	function deletePresentation() {
	
	}

	/* NOTES FUNCTIONALITY */
	function addNotes() {

	}
	function modifyNotes() {

	}
	function deleteNotes() {

	}

	/* CHAT DOC FUNCTIONALITY */
	function addChatDoc() {

	}
	function modifyChatDoc() {

	}
	function deleteChatDoc() {
		
	}
}
?>