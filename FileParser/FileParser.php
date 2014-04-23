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
      				//echo "Upload: " . $_FILES["files"]['name'][$index] . "<br>";
      				//echo "Type: " . $_FILES["files"]['type'][$index] . "<br>";
      				//echo "Size: " . ($_FILES["files"]['size'][$index] / 1024) . " kB<br>";
      				//echo "Temp file: " . $_FILES["files"]['tmp_name'][$index] . "<br>";

              $userFolder = "upload/" . $_COOKIE['user'];
              if(!is_dir($userFolder)) {
                mkdir($userFolder, 0777);
              }
              
      				$folder = "upload/" . $_COOKIE['user'] . "/" . $title;
      				if(is_dir($folder)) {
        				delete_files($folder);
        				mkdir($folder, 0700);
        			}
        			else {
      					mkdir($folder, 0700);
      				}

        			move_uploaded_file($_FILES["files"]["tmp_name"][$index], $folder . "/" . $_FILES["files"]["name"][$index]);
    			}
    			else {
    				//Error handling
    			}
  			}
		}
	}
	function deletePresentation($title) {
		$folder = "upload/" . $_COOKIE['user'] . "/" . $title;
		delete_files($folder);
	}

        function delete_files($target) {
            if(is_dir($target)){
                $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned
        
                foreach( $files as $file ){
                    delete_files( $file );      
                }
      
                rmdir( $target );
            } elseif(is_file($target)) {
                unlink( $target );  
            }
        }
}
?>

}
?>