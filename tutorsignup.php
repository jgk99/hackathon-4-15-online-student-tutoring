<?php
session_start();
require_once("includes/dbfuncs.php");
$noredirect="";

$utaken = "";
$etaken = "";
$lastname = "";
$firstname = "";
$email = "";
$username = "";
$password1 = "";
$password2 = "";
$error = "nhappened";
$pmatch = "";
$never = "100";
$name1 = "";
$lname = "";
$email = "";
$password1 = "";
$lname = "";
$price = "";
$imgname = "";
$subjects="";
$message="";


if (isset($_POST['submit'])) {
	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$email = $_POST["email"]; 
	$username = $_POST["username"];
	$password1 = $_POST["pw"];
	$password2 = $_POST["pw-verify"];
	$price = $_POST["price"];
        $imgname= $_FILES['uploadPicture']['tmp_name'];
        $subjects= $_POST['subjects'];
        $message= $_POST['message'];
//echo "<pre>";
//print_r($_FILES);
//echo "</pre>";
	
    
	if($firstname == "" || $lastname == "") {
		$error = "happened";

		$pmatch .='<br><font color=red>Please enter your whole name</font>';
	}
	if($username == "") {
		$error = "happened";
		$pmatch .='<br><font color=red>Please enter a username</font>';
	}

	if($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = "happened";
		$pmatch .='<br><font color=red>Please enter a valid email</font>';

		
	}
	
	

	if ($password1 == "") {
		$error = "happened";
		$pmatch .='<br><font color=red>Please enter a password</font>';
	}

	else if($password1!=$password2){
		$error = "happened";
		$pmatch .='<br><font color=red>Passwords do not match</font>';
	}

	else if (strlen($password1) < 8) {
		$error = "happened";
		$pmatch .='<br><font color=red>Password must be 8 characters in length</font>';
	}

	/* session_start();
	$_SESSION["in"]="378";
	$_SESSION["name"]="$name";
	$_SESSION["lname"]="$lname";
	$_SESSION["password"]="$password1";
	$_SESSION["email"]="$email";
	*/ 



    if($error==="nhappened"){
            

            $id = addTutor($lastname, $firstname, $username, $email, $password1,$price, $subjects,$message);
               //print_r($id);
    
            $target_dir = "pictures/";
            $uploadfile = $target_dir . "article_image_" . $id . ".jpeg";
            if (move_uploaded_file($imgname, $uploadfile)) {
             //echo "File is valid, and was successfully uploaded.\n";
            } else {
             //echo "Possible file upload attack!\n";
            }

 		if ($noredirect) {

 		}
 		else {
 	
		
		$userid = getTutorIDFromUsername($username);
		$_SESSION["id"] = $userid;
		header("Location: index.php");
		exit();

 		}
	}
}



?>

<!DOCTYPE html>

<html>
<head>
	<title>Tutor Finder</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<meta charset="UTF-8">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>



<div class="container">
	<?php require_once("includes/header.php"); ?> 
	<div class="col-md-6 col-md-offset-3">
		<br /><br />
		<h2>Tutor Sign Up</h2>
		<br />
		<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script> -->
		<form action="tutorsignup.php" method="POST" id="register" enctype="multipart/form-data" data-parsley-validate>
			<table align="left">
				<tr>
					<td align="left" class="form-label">First Name: </td>
					<td align="left"><input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>" required /></td>
				</tr>
				<tr>
					<td align="left" class="form-label">Last Name: </td>
					<td align="left"><input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>" required /></td>
				</tr>
				<tr>
					<td class="form-label">Username: </td>
					<td align="left"><input type="text" name="username" class="form-control" value="<?php echo $username; ?>" required /></td>
				</tr>
				<tr>
					<td class="form-label">Email: </td>
					<td align="left"><input type="email" name="email" data-parsley-type="email" class="form-control" value="<?php echo $email; ?>" required /></td>
				</tr>
				<tr>
					<td class="form-label">Password: </td>
					<td align="left"><input type="password" name="pw" id="pw" minlength="8"  class="form-control"  value="<?php echo $password1; ?>" required /></td>
				</tr>
				<tr>
					<td class="form-label">Confirm Password: </td>
					<td align="left"><input type="password" name="pw-verify" data-parsley-equalto="#pw" class="form-control"  value="<?php echo $password2; ?>" required /></td>
				</tr>
                                <tr>
					<td align="left" class="form-label">Personal Message: </td>
					<td align="left"><textarea rows="10" name ="message" class="form-control"></textarea></td>
				</tr>
                                
                                
                                
                                
                                
				<br/><?php echo $pmatch; ?><?php echo $utaken; ?><?php echo $etaken; ?>
				<tr>
					<tr>
					<td class="form-label">Price: </td>
					<td align="left"><input type="text" name="price" class="form-control" value="<?php echo $price; ?>" required /></td>
				</tr>
                                
                                <tr>
                                <td>Image:</td>
					<td align="left">
                                        
                                        
                                        <input type="file" name="uploadPicture" required />
                                        
                                                                        
                                        
                                        </td>
                                
                                </tr>
                                
                                <tr>
                                <td>Subjects:</td>
					<td align="left">
                                        <br>
                                        <input type="radio" name="subjects" value ="math"/> Math
                                        <br>
                                        <input type="radio" name="subjects" value ="science"/> Science
                                        <br>
                                        <input type="radio" name="subjects" value ="history"/> History
                                        <br>
                                        <input type="radio" name="subjects" value ="english"/> English
                                        <br>
                                        <input type="radio" name="subjects" value ="foreign language"/> Foreign Language
                                        <br>
                                        <br>
                                        </td>
                                
                                </tr>
                                
					<td></td>
					<td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary" /></td>
				</tr>


			<!--<script type="text/javascript">
			 		$(document).ready(function(){    
						$('#form').parsley();
				});	
			</script> -->
			</table>
		</form>
	</div>
</div>
<br /><br /><br /><br /><br /><br /><br /><br />

<?php require_once("includes/footer.php"); ?>

</body>
</html>