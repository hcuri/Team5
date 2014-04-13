<?php
  function dbconnect() {
    //$username = "katykarm_team5";
    //$password = "team5password";
    $username = "root";
    $password = "password";
    
    try {
      $conn = new PDO('mysql:host=localhost;dbname=upresent', $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
    }

    return $conn; 
    
  }

  function getUserId($username) {
    $sql = "SELECT userId FROM Users WHERE username=:username";
    try {
      $db = dbconnect();
      $stmt = $db->prepare($sql);  
      $stmt->bindParam("username", $username);
      $stmt->execute();
      if($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $userId = $row['userId'];
      }
      else 
        return "SOMESHIT";
      return $userId;
      $db = null;
    } catch(PDOException $e) {
      //Do some shit
    }
  }

  function debug_to_console( $data ) {
    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    echo $output;
  }
?>
