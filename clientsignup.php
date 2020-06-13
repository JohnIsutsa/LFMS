<?php include 'includes/connection.php' ?>

<?php include 'includes/header.php' ?>
<?php include 'includes/navbar.php' ?>

<?php
if (isset($_POST['signup'])) {
require "gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
  'username'    => 'required|alpha_numeric|max_len,20|min_len,4',
  'name'        => 'required|alpha_space|max_len,30|min_len,5',
  'email'       => 'required|valid_email',
  'password'    => 'required|max_len,50|min_len,6',
  'contactperson' => 'required|alpha_space|max_len,30|min_len,5',
));
$gump->filter_rules(array(
  'username' => 'trim|sanitize_string',
  'name'     => 'trim|sanitize_string',
  'password' => 'trim',
  'email'    => 'trim|sanitize_email',
  'contactperson' => 'trim|sanitize_string',
  ));
$validated_data = $gump->run($_POST);

if($validated_data === false) {
  ?>
  <center><font color="red" > <?php echo $gump->get_readable_errors(true); ?> </font></center>
  <?php
}
else if ($_POST['password'] !== $_POST['repassword']) 
{
  echo  "<center><font color='red'>Passwords do not match </font></center>";
}
else {
      $username = $validated_data['username'];
      $checkusername = "SELECT * FROM clients WHERE username = '$username'";
      $run_check = mysqli_query($conn , $checkusername) or die(mysqli_error($conn));
      $countusername = mysqli_num_rows($run_check); 
      if ($countusername > 0 ) {
    echo  "<center><font color='red'>Username is already taken! try a different one</font></center>";
}
$email = $validated_data['email'];
$checkemail = "SELECT * FROM clients WHERE email = '$email'";
      $run_check = mysqli_query($conn , $checkemail) or die(mysqli_error($conn));
      $countemail = mysqli_num_rows($run_check); 
      if ($countemail > 0 ) {
    echo  "<center><font color='red'>Email is already taken! try a different one</font></center>";
}

  else {
      $name = $validated_data['name'];
      $email = $validated_data['email'];
      $pass = $validated_data['password'];
      $password = password_hash("$pass" , PASSWORD_DEFAULT);
      $contactperson = $validated_data['contactperson'];
      $lawyer_id = $_POST['lawyer'];
      $joindate = date("F j, Y");
      $query = "INSERT INTO clients(client_name, username, contact_person, email, password, token, join_date, lawyer_id) VALUES ('$name', '$username' , '$contactperson', '$email', '$password', '' ,   		'$joindate', '$lawyer_id')";
      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) { 
        echo "<script>alert('SUCCESSFULLY REGISTERED');
        window.location.href='login.php';</script>";
}
else {
  echo "<script>alert('Error Occured');</script>";
}
}
}
}
?>
<br>

<div class="container">


      <div  class="form">
        <form id="contactform" method="POST"> 
          <p class="contact"><label for="name">Client Name</label></p> 
          <input id="name" name="name" placeholder="company or individual name" required="" tabindex="1" type="text" value="<?php if(isset($_POST['signup'])) { echo $_POST['name']; } ?>"> 

          <p class="contact"><label for="name">Contact Person</label></p> 
          <input id="contactperson" name="contactperson" placeholder="First and Last name" required="" tabindex="1" type="text" value="<?php if(isset($_POST['signup'])) { echo $_POST['contactperson']; } ?>"> 

          <p class="contact"><label for="username">Create a username</label></p> 
          <input id="username" name="username" placeholder="username" required="" tabindex="2" type="text" value="<?php if(isset($_POST['signup'])) { echo $_POST['username']; } ?>"> 

          <p class="contact"><label for="email">Email</label></p> 
          <input id="email" name="email" placeholder="example@domain.com" required="" type="email" value="<?php if(isset($_POST['signup'])) { echo $_POST['email']; } ?>"> 


                
                
           
                <p class="contact"><label for="password">Create a password</label></p> 
          <input type="password" id="password" name="password" required=""> 
                <p class="contact"><label for="repassword">Confirm your password</label></p> 
          <input type="password" id="repassword" name="repassword" required=""> 

          <?php 
          		$query = "SELECT lawyer_id, lawyer_name FROM lawyer"; 
          		$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
          	?> 
          		<p class="contact"><label for="lawyer">Select Lawyer</label></p> 
          		<select class="select-sytle gender" name="lawyer">
          			<?php
          			while($rows = $result->fetch_assoc()) 
          			{
          				$id = $rows['lawyer_id'];
          				$name = $rows['lawyer_name'];
          				echo "<option value='$id'>$id - $name</option>";
          			}

          			?>
          		</select>

          	</br>
          </br>
          
            
            <input class="buttom" name="signup" id="submit" tabindex="5" value="Sign me up!" type="submit">    
   </form> 
</div>      
</div>

</body>
</html>