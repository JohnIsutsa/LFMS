<?php include 'includes/connection.php'; 
 include 'includes/adminheader.php'; ?>

<?php 
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username']; 
		$role = $_SESSION['role'];
		if ($role == 'client') {
			$query = "SELECT * FROM clients WHERE username = '$username'"; 
			$result = mysqli_query($conn, $query) or die(mysqli_error($conn)); 
			if (mysqli_num_rows($result)>0) {
				$row = mysqli_num_rows($result);
				$userid = $row['client_id'];
				$usernm = $row['username'];
				$userpassword = $row['password'];
				$useremail = $row['email'];
				$name = $row['client_name'];
				$profilepic = $row['image'];
				$bio = $row['bio'];			
			}
		}
		elseif ($role == 'lawyer') {
			$query = "SELECT * FROM lawyer WHERE username = '$username'"; 
			$result = mysqli_query($conn, $query) or die(mysqli_error($conn)); 
			if (mysqli_num_rows($result)>0) {
				$row = mysqli_num_rows($result);
				$userid = $row['lawyer_id'];
				$usernm = $row['username'];
				$userpassword = $row['password'];
				$useremail = $row['email'];
				$name = $row['lawyer_name'];
				$profilepic = $row['image'];
				$bio = $row['bio'];
			}
		}	

		if (isset($_POST['uploadphoto'])) {
		$image = $_FILES['image']['name'];
		$ext = $_FILES['image']['type'];
		$validExt = array ("image/gif",  "image/jpeg",  "image/pjpeg", "image/png");
		if (empty($image)) {
			$picture = $profilepic; 
		}
		elseif ($_FILES['image']['size'] < 0 || $_FILES['image']['size'] > 1024000) {
			echo "<script>alert('Image size is not proper. Should be between 0 and 1MB ');
 				window.location.href='userprofile.php';</script>";
		} 
		elseif (!in_array($ext, $validExt)) {
			echo "<script>alert('Image file type is not correct.');
			window.location.href='userprofile.php'</script>";
		}
		else {
			$folder = 'profilepics/';
			$imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION)); 
			$picture = rand(1000, 1000000).'.'.$imgext; 
				if ($role == 'client') {
						if(move_uploaded_file($_FILES['image']['temp_name'], $folder.$picture)){
						$updatequery = "UPDATE clients SET image = $picture WHERE id = $userid";
						$result1 = mysqli_query($conn, $updatequery) or die(mysqli_error($conn));  
							if (mysqli_affected_rows($conn)>0) {
								echo "<script>alert('Profile picture updated!');
								window.location.href = 'userprofile.php'</script>";	
							} else {
								echo "<script>alert('Error!... Try again');</script>";
							}
						} else {
							echo "<script>alert('Error occurred while uploading!...Try again.');</script>";
						}
				} elseif ($role == 'lawyer') {
						if(move_uploaded_file($_FILES['image']['temp_name'], $folder.$picture)){
						$updatequery = "UPDATE lawyer SET image = $picture WHERE id = $userid";
						$result1 = mysqli_query($conn, $updatequery) or die(mysqli_error($conn));  
							if (mysqli_affected_rows($conn)>0) {
								echo "<script>alert('Profile picture updated!');
								window.location.href = 'userprofile.php'</script>";	
							} else {
								echo "<script>alert('Error!... Try again');</script>";
							}
						} else {
							echo "<script>alert('Error occurred while uploading!...Try again.');</script>";
						}
				}
			
		}
	}
	else {
		$picture = $row['image']; 
	}

	if (isset($_POST['update'])) {
		require '../gump.class.php'; 
		$gump = new GUMP(); 
		$_POST = $gump->sanitize($_POST); 

		$gump->validation_rules(array(
			'name'   => 'required|alpha_space|max_len,30|min_len,2',
			'email'       => 'required|valid_email',
    		'bio'    => 'max_len,150',
			'currentpassword' => 'required|max_len,50|min_len,6',
			'newpassword'    => 'max_len,50|min_len,6',
		)); 

		$gump->filter_rules(array(
			'name' => 'trim|sanitize_string',
			'currentpassword' => 'trim',
			'newpassword' => 'trim',
			'email'    => 'trim|sanitize_email',
			'bio' => 'trim',
		)); 
		$validated_data = $gump->run($_POST); 
		if($validated_data === false) { ?>
			<center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
			<?php
		}
		elseif (!password_verify($validated_data['currentpassword'], $userpassword)) {
			echo  "<center><font color='red'>Current password is wrong! </font></center>";
		}
		elseif (empty($_POST['newpassword'])) {
			$name = $validated_data['name'];
			$useremail = $validated_data['email'];
      		$userbio = $validated_data['bio']; 

      		if ($role == 'client') {
      			$updatequery2 = "UPDATE clients SET client_name = '$name' , email='$useremail' , bio='$userbio' WHERE id = '$userid'";
      			$result2 = mysqli_query($conn, $updatequery2) or die(mysqli_error($conn)); 
      			if (mysqli_affected_rows($conn)>0) {
      				echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');
    					window.location.href='userprofile.php';</script>";	
      			} else {
      				echo "<script>alert('An error occured, Try again!');</script>";
      			}
      		} elseif ($role == 'lawyer') {
      			$updatequery2 = "UPDATE lawyer SET lawyer_name = '$name', email='$useremail', bio = '$userbio' WHERE id = '$userid'"; 
      			$result2 = mysqli_query($conn, $updatequery2) or die(mysqli_error($conn)); 
      			if (mysqli_affected_rows($conn)>0) {
      				echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');
      						window.location.href='userprofile.php';</script>";
      			} else { 
      				echo "<script>alert('An error occured, Try again!');</script>";
      			}
      		}

		}
		elseif (isset($_POST['newpassword']) && $_POST['newpassword'] !== $_POST['confirmnewpassword']) {
			echo  "<center><font color='red'>New password and Confirm New password do not match </font></center>";
		}
		else {
			$name = $validated_data['name'];
      		$useremail = $validated_data['email'];
      		$pass = $validated_data['newpassword'];
      		$userpassword = password_hash("$pass" , PASSWORD_DEFAULT);

      		if ($role == 'client') {
      			$updatequery3 = "UPDATE clients SET password='$userpassword', client_name = '$name' , email='$useremail' , bio='$userbio' WHERE id = '$userid' ";
      			$result3 = mysqli_query($conn, $updatequery3) or die(mysqli_error($conn));
      			if (mysqli_affected_rows($conn)>0) {
      				echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');
      						window.location.href='userprofile.php';</script>";
      			} else {
      				echo "<script>alert('An error occured, Try again!');</script>";
      			}
      		} elseif ($role == 'lawyer') {
      			$updatequery3 = "UPDATE lawyer SET password='$userpassword', lawyer_name = '$name' , email='$useremail' , bio='$userbio' WHERE id = '$userid' ";
      			$result3 = mysqli_query($conn, $updatequery3) or die(mysqli_error($conn));
      			if (mysqli_affected_rows($conn)>0) {
      				echo "<script>alert('PROFILE UPDATED SUCCESSFULLY');
      						window.location.href='userprofile.php';</script>";		
      			} else {
      				echo "<script>alert('An error occured, Try again!');</script>";
      			}
      		}

		}


	}
	
	}

?>

<div id="wrapper">

        
      <!-- <?php //include 'includes/adminnav.php';?>-->
        <div id="page-wrapper">

            <div class="container-fluid">

                
                <div class="row">
                        <h1 class="page-header">
                    <div class="col-lg-12">
                            Welcome to your Profile 
                            <small><?php echo $_SESSION['name']; ?></small>
                        </h1>
<form role="form" action="" method="POST" enctype="multipart/form-data">



<div class="form-group">
        <label for="post_image">Profile Image</label>
		<img class="img-responsive" width="200" src="profilepics/<?php echo $picture; ?>" alt="Photo">
		<input type="file" name="image"> 
		<br>
		<button type="submit" name="uploadphoto" class="btn btn-primary" value="upload photo">upload photo</button>
    </div>
</form>


    <form role="form" action="" method="POST" enctype="multipart/form-data">
    <hr>


<div class="form-group">
		<label for="user_title">User Name</label>
		<input type="text" name="username" class="form-control" value=" <?php echo $username; ?>" readonly>
	</div>



	<div class="form-group">
		<label for="user_author">Name</label>
		<input type="text" name="name" class="form-control"  value="<?php echo $name; ?>" required>
	</div>

	<div class="form-group">
		<label for="user_tag">Email</label>
		<input type="email" name="email" class="form-control"  value="<?php echo $useremail; ?>" required>
	</div>
	<div class="form-group">
		<label for="post_content">Bio</label>
		<textarea  class="form-control" name="bio" id="" cols="30" rows="10"><?php  echo $bio;  ?>
		</textarea>
	</div>

	<div class="form-group">
		<label for="usertag">Current Password</label>
		<input type="password" name="currentpassword" class="form-control" placeholder="Enter Current password" required>
	</div>
	<div class="form-group">
		<label for="usertag">New Password <font color='brown'> (changing password is optional)</font></label>
		<input type="password" name="newpassword" class="form-control" placeholder="Enter New Password">
	</div>
	<div class="form-group">
		<label for="usertag">Confirm New Password</label>
		<input type="password" name="confirmnewpassword" class="form-control" placeholder="Re-Enter New Password" >
	</div>
<hr>


<button type="submit" name="update" class="btn btn-primary" value="Update User">Update User</button>

                    </div>
                </div>
                

            </div>
            

    </div>
    
    <script src="js/jquery.js"></script>

    
    <script src="js/bootstrap.min.js"></script>

</body>

</html>