<?php

require 'Slim/Slim.php';
require '../php/lib.php';

$app = new Slim();

$app->get('/recent_order/:email', 'getRecentOrder');
$app->get('/locations',	'getLocations');
$app->get('/verify/:email/:pass', 'verifyRegistered');
$app->get('/menu/:itemType', 'getMenuItems');
$app->get('/registered/:email', 'checkIfRegistered');
$app->post('/register', 'registerUser');
$app->get('/menu/fixin_price/:name', 'getFixinPrice');
$app->get('/email_to_id/:email', 'emailToID');
$app->post('/add_order', 'addOrder');
$app->get('/time_to_orderid/:timestamp', 'timeToOrderId');
$app->post('/add_order_item', 'addOrderItem');
$app->post('/add_order_item_detail', 'addOrderItemDetails');
$app->get('/orderId_to_orderItemId/:orderId', 'orderIdToOrderItemId');
$app->get('/fixinName_to_Id/:fixinName', 'fixinNameToId');

$app->run();

function getRecentOrder($email) {
	$sqlID = "SELECT UserId FROM Users WHERE EmailAddress=:email";
	$sqlOrder = "SELECT t1.* FROM Orders t1 INNER JOIN (
  				SELECT max(Dates) MostRecentOrder
  				FROM Orders WHERE UserId=:UserId) t2
  				ON t1.Dates = t2.MostRecentOrder";
	$sqlOrderItem = "SELECT OrderItemId, Quantity FROM OrderItem WHERE OrderId=:orderId";
	$sqlOrderItemDetails = "SELECT TacoFixinId From OrderItemDetails WHERE OrderItemId=:orderItemId";
	$sqlTacoFixins = "SELECT name FROM Menu WHERE TacoFixinId=:fixinId";
	try {
		$db = dbconnect();
		$stmtID = $db->prepare($sqlID);
		$stmtID->bindParam("email", $email);
		$stmtID->execute();  
		$uID = $stmtID->fetch(PDO::FETCH_ASSOC);
		$userID = $uID['UserId'];
		
		$stmtOrder = $db->prepare($sqlOrder);
		$stmtOrder->bindParam("UserId", $userID);
		$stmtOrder->execute();
		$order = $stmtOrder->fetch(PDO::FETCH_ASSOC);	
		$orderDate = $order['Dates'];
		$orderTotal = $order['Total'];
		$orderId = $order['OrderId'];
		
		$stmtOrderItem = $db->prepare($sqlOrderItem);
		$stmtOrderItem->bindParam("orderId", $orderId);
		$stmtOrderItem->execute();

		$jsonTacos = '';
		
		
		for($i = 0; $i < $stmtOrderItem->rowCount(); $i++) {
			$orderItem = $stmtOrderItem->fetch(PDO::FETCH_ASSOC);
			$orderItemId = $orderItem['OrderItemId'];
			$jsonTacos = $jsonTacos . '{"OrderItemId":"' . $orderItemId . '","Quantity":"' 
					. $orderItem['Quantity'] . '","TacoFixins":[';
			$stmtOrderItemDetails = $db->prepare($sqlOrderItemDetails);
			$stmtOrderItemDetails->bindParam("orderItemId", $orderItemId);
			$stmtOrderItemDetails->execute();
			for($j = 0; $j < $stmtOrderItemDetails->rowCount(); $j++) {
				$orderItemDetail = $stmtOrderItemDetails->fetch(PDO::FETCH_ASSOC);
				$fixinId = $orderItemDetail['TacoFixinId'];
				$stmtTacoFixins = $db->prepare($sqlTacoFixins);
				$stmtTacoFixins->bindParam("fixinId", $fixinId);
				$stmtTacoFixins->execute();
				$fixinName = $stmtTacoFixins->fetch(PDO::FETCH_ASSOC);
				$jsonTacos = $jsonTacos . '{"name":"' . $fixinName['name'] . '"';
				if($stmtOrderItemDetails->rowCount() - $j == 1) 
					$jsonTacos = $jsonTacos . '}';	
				else 
					$jsonTacos = $jsonTacos . '},';
			}
			if($stmtOrderItem->rowCount() - $i == 1) 
				$jsonTacos = $jsonTacos . ']}';	
			else 
				$jsonTacos = $jsonTacos . ']},';
		}
		
		
		
		$db = null;
		echo '{"recent_order": {"date_time":"' .$orderDate. '","total":"' .$orderTotal. '","tacos":[' . $jsonTacos . ']}}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getLocations() {
	$sql = "SELECT * FROM Locations";
	try {
		$db = dbconnect();
		$stmt = $db->query($sql);  
		$locations = $stmt->fetchAll(PDO::FETCH_OBJ);  
		$db = null;
		echo '{"locations": ' . json_encode($locations) . '}'; 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function verifyRegistered($email, $password) {
	$sql = "SELECT * FROM Users WHERE EmailAddress=:email";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("email", $email);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
			if(password_verify($password, $userInfo['Password']))
				echo '{"registered": true}';
			else echo '{"registered": false}';	
		}
		else echo '{"registered": false}';
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getMenuItems($itemType) {
	$sql = "SELECT * FROM Menu WHERE itemType=:itemType";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("itemType", $itemType);
		$stmt->execute();
		$item = $stmt->fetchAll(PDO::FETCH_OBJ);  
		$db = null;
		echo json_encode($item); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function checkIfRegistered($email) {
	$sql = "SELECT * FROM Users WHERE EmailAddress=:email";

	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("email", $email);
		$stmt->execute();  
		if($stmt->rowCount() > 0)
			echo '{"email_registered": true}';  
		else 
			echo '{"email_registered": false}';
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function registerUser() {
	error_log('addUser\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$user = json_decode($request->getBody());
	$pass = password_hash($user->pw, PASSWORD_DEFAULT);
	$sql = "INSERT INTO Users VALUES (DEFAULT, :fName, :lName, :email, :pw, :tele, :ccp, :ccnum)";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);   
		$stmt->bindParam("fName", $user->fName);
		$stmt->bindParam("lName", $user->lName);
		$stmt->bindParam("email", $user->email);
		$stmt->bindParam("pw", $pass);
		$stmt->bindParam("tele", $user->tele);
		$stmt->bindParam("ccp", $user->ccp);
		$stmt->bindParam("ccnum", $user->ccnum);
	       	$stmt->execute();
		$db = null; 
		echo json_encode($user); 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
	
}

function getFixinPrice($name) {
	$sql = "SELECT price FROM Menu WHERE name=:name";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("name", $name);
		$stmt->execute();
		$price = $stmt->fetch(PDO::FETCH_ASSOC); 
		$db = null;
		echo '{"price": '.$price['price']. '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() . '}}';
	}
}

function addOrder() {
	$request = Slim::getInstance()->request();
	$order = json_decode($request->getBody());
	$sql = "INSERT INTO Orders VALUES (DEFAULT, :userId, :date, :total)";

	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("userId", $order->UserId);
		$stmt->bindParam("date", $order->date);
		$stmt->bindParam("total", $order->total);
		$stmt->execute();
		$db = null;
		echo json_encode($order);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() . '}}';
	}
}

function emailToID($email) {
	$sql = "SELECT UserId FROM Users WHERE EmailAddress=:email";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("email", $email);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC); 
		$db = null;
		echo '{"UserId": '.$user['UserId']. '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() . '}}';
	}
}

function addOrderItem() {
	$request = Slim::getInstance()->request();
	$orderItem = json_decode($request->getBody());
	$sql = "INSERT INTO OrderItem VALUES (DEFAULT, :orderId, :quantity)";

	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("orderId", $orderItem->OrderId);
		$stmt->bindParam("quantity", $orderItem->quantity);
		$stmt->execute();
		$db = null;
		echo json_encode($orderItem);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() . '}}';
	}
}

function timeToOrderId($timestamp) {
	$sql = "SELECT OrderId FROM Orders WHERE Dates=:timestamp";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("timestamp", $timestamp);
		$stmt->execute();
		$order = $stmt->fetch(PDO::FETCH_ASSOC); 
		$db = null;
		echo '{"OrderId": '.$order['OrderId']. '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() . '}}';
	}
}

function addOrderItemDetails() {
	$request = Slim::getInstance()->request();
	$orderItemDetails = json_decode($request->getBody());
	$sql = "INSERT INTO OrderItemDetails VALUES (DEFAULT, :orderItemId, :fixinId)";

	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("orderItemId", $orderItemDetails->OrderItemId);
		$stmt->bindParam("fixinId", $orderItemDetails->fixinId);
		$stmt->execute();
		$db = null;
		echo json_encode($orderItemDetails);
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() . '}}';
	}
}

function orderIdToOrderItemId($orderId) {
	$sql = "SELECT OrderItemId FROM OrderItem WHERE OrderId=:orderId";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("orderId", $orderId);
		$stmt->execute();
		$rows = $stmt->rowCount();
		for($i = 1; $i <= $rows; $i++) {
			$orderItem = $stmt->fetch(PDO::FETCH_ASSOC);
			if( $i == $rows) {
				echo '{"OrderItemId": '.$orderItem['OrderItemId']. '}';
			}
		}
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() . '}}';
	}
}

function fixinNameToId($name) {
	$sql = "SELECT TacoFixinId FROM Menu WHERE name=:name";
	try {
		$db = dbconnect();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("name", $name);
		$stmt->execute();
		$price = $stmt->fetch(PDO::FETCH_ASSOC); 
		$db = null;
		echo '{"TacoFixinId": '.$price['TacoFixinId']. '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() . '}}';
	}
}
?>
