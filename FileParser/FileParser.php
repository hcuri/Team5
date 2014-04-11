<?php
class FileParser {
	//JSON to return for errors
	$err;

	function modifyPresentation($files, $title) {
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post' && !empty($_FILES)) {

  			foreach($_FILES['files']['tmp_name'] as $index => $tmpName) {

    			if ((($_FILES["files"]["type"][$index] == "image/gif")
      				|| ($_FILES["files"]["type"][$index] == "image/jpeg")
      				|| ($_FILES["files"]["type"][$index] == "image/jpg")
      				|| ($_FILES["files"]["type"][$index] == "image/pjpeg")
      				|| ($_FILES["files"]["type"][$index] == "image/x-png")
      				|| ($_FILES["files"]["type"][$index] == "image/png"))
      				&& ($_FILES["files"]["size"][$index] < 200000000000))
    			{
      				echo "Upload: " . $_FILES['files']['name'][$index] . "<br>";
      				echo "Type: " . $_FILES['files']['type'][$index] . "<br>";
      				echo "Size: " . ($_FILES['files']['size'][$index] / 1024) . " kB<br>";
      				echo "Temp file: " . $_FILES['files']['tmp_name'][$index] . "<br>";

      				$folder = "../upload/" . $title;
      				if(is_dir($folder)) 
        				rmdir($folder);
        			else 
      					mkdir($folder, 0700);

        			move_uploaded_file($_FILES["files"]["tmp_name"][$index], $folder . "/" . $_FILES["files"]["name"][$index]);
    			}
    			else {
    				//Error handling, change $err
    				return $err;
    			}
  			}
		}
	}
	function deletePresentation() {
		if()
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