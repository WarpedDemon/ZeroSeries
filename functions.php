<?php 
/* Functions Zero Series */


function createConnectionObject() {
	try {
		$db = new PDO('mysql:host=localhost;dbname=zeroseries;','root','');
	}
	catch(PDOException $e) {
		echo '<div class="alert alert-danger"><strong>Error:</strong> We couldn\'t connect to our database! Error Message: ' . $e->getMessage() .'</div>';
		return false;
	}
	return $db;

}


function getImages() {
	$db = createConnectionObject();
	if($db == false) { return "error_connection"; }
	$imageArray = array();
	$stmt = "SELECT * FROM images";
	
	$query = $db->prepare($stmt);
	$query->execute();
	
	while($row = $query->fetch(PDO::FETCH_ASSOC)) {
		if($row) {
			array_push($imageArray, $row);
		}
	}
	if(empty($imageArray)) {
		return false;
	}
	return $imageArray;
}
	
	
function loginUser($username, $password) {
	$db = createConnectionObject();
	if($db == "error") { return false; }
	
	$stmt = "SELECT * FROM logins WHERE username=:username and password=:password";
	
	$query = $db->prepare($stmt);
	$query->execute(array("username"=>$username, "password"=>$password));
	
	$result = $query->fetch(PDO::FETCH_ASSOC);
	
	if($result == 0) {
		return false;
	} else {
		return $result;
	}
}






 ?>