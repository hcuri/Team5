<?php
require_once("../php/lib.php");

class FileParser {
	//JSON to return for errors
	//$err;

	function modifyPresentation($files, $title) {
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post' && !empty($_FILES)) {

	    	try {
				$sql = "SELECT presId 
						FROM Presentations 
						WHERE presName = :title  
						AND ownerId = :username;";
				$db = dbconnect();
				$stmt = $db->prepare($sql);   
				$stmt->bindParam("title", $title);
				$stmt->bindParam("username", $_COOKIE['user']);
	    		$stmt->execute();
	    		$pres = $stmt->fetch(PDO::FETCH_ASSOC);
	    		$presId = $pres['presId'];
			} catch(PDOException $e) {
				error_log($e->getMessage(), 3, '/var/tmp/php.log');
				echo '{"error":{"text":'. $e->getMessage() .'}}';
			}

  			foreach($files['tmp_name'] as $index => $tmpName) {

    			if ((($files["type"][$index] == "image/gif")
      				|| ($files["type"][$index] == "image/jpeg")
      				|| ($files["type"][$index] == "image/jpg")
      				|| ($files["type"][$index] == "image/pjpeg")
      				|| ($files["type"][$index] == "image/x-png")
      				|| ($files["type"][$index] == "image/png"))
      				&& ($files["size"][$index] < 200000000000))
    			{
      				echo "Upload: " . $files['name'][$index] . "<br>";
      				echo "Type: " . $files['type'][$index] . "<br>";
      				echo "Size: " . ($files['size'][$index] / 1024) . " kB<br>";
      				echo "Temp file: " . $files['tmp_name'][$index] . "<br>";

      				$folder = "../upload/" . $_COOKIE['user'] . "/" . $presId;
      				if(is_dir($folder)) 
        				rmdir($folder);
        			else 
      					mkdir($folder, 0700);

        			move_uploaded_file($files["tmp_name"][$index], $folder . "/" . $files["name"][$index]);
    			}
    			else {
                                //why not just put $err in here?
                                //Error handling, change $err
    				return $err;
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