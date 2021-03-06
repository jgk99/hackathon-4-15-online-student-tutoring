<?php 

function dbconnect() {
	//Create connection
	$con = new mysqli('172.16.89.144', 'root', 'root', 'tutors', '8889');

	//Test Connection
	if (mysqli_connect_errno()) {
		throw new Exception("Connection failed with error %s", mysqli_connect_error());
	}

	//Return connection
	return $con;
}



function addUser($lname, $fname, $usrname, $email, $pass, $message) {
	//Connecto to database
	$con = dbconnect();

	//Sanitize Variables
	$lname = $con->real_escape_string($lname);
	$fname = $con->real_escape_string($fname);
        $message = $con->real_escape_string($message);
	$usrname = $con->real_escape_string($usrname);
	$email = $con->real_escape_string($email);
	$pass = $con->real_escape_string(hash("sha256", $pass)); //Hash password using SHA256 algorithm

	//Build query string
	$query = "INSERT INTO `users` (`lastname`, `firstname`, `username`, `email`, `password`,'message') VALUES ('$lname', '$fname', '$usrname', '$email', '$pass','$message')";

	//Execute query and check for errors
	if (!$con->query($query)) {
		throw new mysqli_sql_exception("$con->error");
	}
	$con->close();
}

function addTutor($lname, $fname, $usrname, $email, $pass, $price, $subjects, $message) {
	//Connecto to database
	$con = dbconnect();

	//Sanitize Variables
	$price = $con->real_escape_string($price);
	$lname = $con->real_escape_string($lname);
        $message = $con->real_escape_string($message);
	$fname = $con->real_escape_string($fname);
	$usrname = $con->real_escape_string($usrname);
	$email = $con->real_escape_string($email);
	$pass = $con->real_escape_string(hash("sha256", $pass)); //Hash password using SHA256 algorithm

	//Build query string

	$query = "INSERT INTO `Tutors` (`lastname`, `firstname`, `username`, `email`, `password`,`price`,`subject`,'message') VALUES ('$lname', '$fname', '$usrname', '$email', '$pass','$price','$subjects','$message')";


 
mysqli_query($con,$query);

        return mysqli_insert_id($con);
}



		
function getTutorIDFromUsername($username) {
	$con = dbconnect();

	$username = $con->real_escape_string($username);

	$query = "SELECT `tutor_id` FROM `tutors` WHERE `username` = '$username'";
	$data = $con->query($query);
	if (!$data) {
		//throw new mysqli_sql_exception("Query failed with error: $con->sqlstate");
	} else {
		//Check if query returned a row results
		if ($data->num_rows == 1) {
			$row = mysqli_fetch_assoc($data);
			return $row["tutor_id"];
		} else {
			return false;
		}
	}
}

function validateUser($usrname, $passwd) {
	//Connect to database
	$con = dbconnect();

	//Sanitize Variables
	$usrname = $con->real_escape_string($usrname);
	$passwd = $con->real_escape_string(hash("sha256",$passwd)); //Hash password using SHA256 algorithm


	//Build query string
	$query = "SELECT `username` FROM `users` WHERE `username` = '$usrname' and `password` = '$passwd'";
	
	//Execute query and check for errors
	$data = $con->query($query);
	if (!$data) {
		//throw new mysqli_sql_exception("Query failed with error: $con->sqlstate");
	} else {
		//Check if query returned a row results
		if ($data->num_rows == 1) {
			//User is valid
			return true;
		} 

		else{
			
			$query = "SELECT `username` FROM `tutors` WHERE `username` = '$usrname' and `password` = '$passwd'";
	
	//Execute query and check for errors
	$data = $con->query($query);

	if($data->num_rows == 1)	{
		return true;
	}
else{
	return false;
}

		}




	}
}

		
function getUserIDFromUsername($username) {
	$con = dbconnect();

	$username = $con->real_escape_string($username);

	$query = "SELECT `user_id` FROM `users` WHERE `username` = '$username'";
	$data = $con->query($query);
	if (!$data) {
		//throw new mysqli_sql_exception("Query failed with error: $con->sqlstate");
	} else {
		//Check if query returned a row results
		if ($data->num_rows == 1) {
			$row = mysqli_fetch_assoc($data);
			return $row["user_id"];
		} else {
			return false;
		}
	}
}




?>