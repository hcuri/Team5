<?php
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

      if (file_exists("upload/" . $_FILES["files"]["name"])) {
        echo $_FILES["files"]["name"] . " already exists. ";
      }
      else {
        move_uploaded_file($_FILES["files"]["tmp_name"][$index], "../upload/" . "Presentation_1/" . $_FILES["files"]["name"][$index]);
        echo "Stored in: " . "upload/Presentation_1" . $_FILES["files"]["name"][$index] . "<br /><br /><br />";
      }
    }
    else {
      echo $_FILES["files"]["name"][$index] . " is an invalid file type<br />";
    }
  }
}





?>