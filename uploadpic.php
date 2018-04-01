<?php session_start(); ?>
<?php
    $servername="localhost";
    $username="root";   
    $password="";
    $dbname="DBMSProject";

    $conn = new mysqli($servername,$username,$password,$dbname);

    if($conn->connect_error)
    {
        die("connection error".$conn->connect_error);
    }

    if(isset($_REQUEST['submit-btnn']))
    {

    	$upload=1;

    	$target_dir = "upload/";
    	$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
    	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
    	{
   			 echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$upload =0;
		}

		if (file_exists($target_file)) 
		{
		    echo "Sorry, file already exists.";
		    $upload = 0;
		}

		if ($_FILES["fileToUpload"]["size"] > 5000000)
		{
		    echo "Sorry, your file is too large.";
		    $upload = 0;
		}


		if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
		{
			$addr = $target_file;
		    $var10 = $_SESSION['type'];
		    $var11 = $_SESSION['username'];
		    if($var10 == "cop")
		    {
		    	$sql = "UPDATE coptable SET photoaddress='$addr' where username = '$var11' ";
		    }
		    if($var10 == "citizen")
		    {
		    	$sql = "UPDATE usertable SET photoaddress='$addr' where username = '$var11' ";
		    }
		    if($var10 == "judge")
		    {
		    	$sql = "UPDATE judgetable SET photoaddress='$addr' where username = '$var11' ";
		    }
		    if($upload ==1)
		    {
		    	$conn->query($sql);
		    }
		}
		else
		{
			echo "nhi hua";
		}
    }
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="uploadpic.css">
	<title>Add Profile Photo</title>

</head>
<body>

	<div class="main-box">
		<div class="inside-box">
			<p style="padding-left: 23%; font-size: 23px; padding-top: 2%;">Add Profile Photo</p>
			<br><br>
			<div class="mericlass" >
				<img src="user-otp.png" id="change-photo" class="rounded-circle">
			</div>
			<p style="text-align: center; font-size: 25px;"><?php echo $_SESSION['username']; ?></p>
			<br>

			<div class="form-group">
				<form method="POST" action="uploadpic.php" enctype="multipart/form-data">
				    <input type="file" name="fileToUpload" id="fileToUpload" >
				   	<small style="color: grey;">Maximum size should be 5MB.</small>
				   	<br>
				   	<small style="color: grey;">Format should be JPG,JPEG,PNG or GIF is allowed.</small>
			    	<button type="submit" name="submit-btnn" class="btn btn-primary">Submit</button>
				</form>
		  	</div>

		  	<br><br>
		  	<p style="color: grey; margin-left: 25%; margin-bottom: 0;">Wanna Sign-in <a href="index.php" style="text-decoration: none;">Home Page</a></p>
		  	<p style="color: grey; margin-left: 30%">&copy;Proness2017-2018</p>
		</div>
	</div>

</body>
</html>