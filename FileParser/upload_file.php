<?php
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);


/*if ((($_FILES["files"]["type"] == "image/gif")
  || ($_FILES["files"]["type"] == "image/jpeg")
  || ($_FILES["files"]["type"] == "image/jpg")
  || ($_FILES["files"]["type"] == "image/pjpeg")
  || ($_FILES["files"]["type"] == "image/x-png")
  || ($_FILES["files"]["type"] == "image/png"))
  && ($_FILES["files"]["size"] < 200000000000)
  && in_array($extension, $allowedExts))
  {*/

      

      //Loop through files and output names / type / size / tmp_name
    if(strtolower($_SERVER['REQUEST_METHOD']) == 'post' && !empty($_FILES)) {
      foreach($_FILES['files']['tmp_name'] as $index => $tmpName) {
        echo "Upload: " . $_FILES['files']['name'][$index] . "<br>";
        echo "Type: " . $_FILES['files']['type'][$index] . "<br>";
        echo "Size: " . ($_FILES['files']['size'][$index] / 1024) . " kB<br>";
        echo "Temp file: " . $_FILES['files']['tmp_name'][$index] . "<br><br><br>";

        if (file_exists("upload/" . $_FILES["files"]["name"])) {
          echo $_FILES["files"]["name"] . " already exists. ";
        }
        else {
          //move_uploaded_file($slide["tmp_name"], "../upload/" . "Presentation_1/" . $slide["name"]);
          //echo "Stored in: " . "upload/Presentation_1" . $slide["name"];
        }
      }
  }
  else {
    echo "Invalid file";
  }





/*
echo "Upload: " . $_FILES["files"]["name"] . "<br>";
      echo "Type: " . $_FILES["files"]["type"] . "<br>";
      echo "Size: " . ($_FILES["files"]["size"] / 1024) . " kB<br>";
      echo "Temp file: " . $_FILES["files"]["tmp_name"] . "<br>";

      if (file_exists("upload/" . $_FILES["files"]["name"])) {
        echo $_FILES["files"]["name"] . " already exists. ";
      }
      else {
        move_uploaded_file($_FILES["files"]["tmp_name"], "../upload/" . $_FILES["files"]["name"]);
        echo "Stored in: " . "upload/" . $_FILES["files"]["name"];
      }
    }
  }
  else {
    echo "Invalid file";
  }
*/
?>