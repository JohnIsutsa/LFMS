<?php include 'includes/connection.php' ?>

<?php include 'includes/header.php'?>
<?php include 'includes/navbar.php' ?>
 

<?php
session_start();
if (isset($_POST['login'])) {
  $username  = $_POST['user'];
  $password = $_POST['pass'];
  mysqli_real_escape_string($conn, $username);
  mysqli_real_escape_string($conn, $password);
$query = "SELECT * FROM clients WHERE username = '$username'";
$result = mysqli_query($conn , $query) or die (mysqli_error($conn));
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    $id = $row['client_id'];
    $user = $row['username'];
    $pass = $row['password'];
    $name = $row['client_name'];
    $email = $row['email'];
    $contact= $row['contact_person'];
    $role = $row['role']; 
    
    if (password_verify($password, $pass )) {
      $_SESSION['id'] = $id; //client id
      $_SESSION['username'] = $username; //username
      $_SESSION['name'] = $name; //client name
      $_SESSION['email']  = $email;
      $_SESSION['contact'] = $contact; //contact person
      $_SESSION['role'] = $role; //user role in this case "client"
      
      header('location: dashboard/');
    }
    else {
      echo "<script>alert('invalid username/password');
      window.location.href= 'clientlogin.php';</script>";

    }
  }
}
else {
      echo "<script>alert('invalid username/password');
      window.location.href= 'clientlogin.php';</script>";

    }
}
?>


<div class="login-card">
    <h1>Client Log-in</h1><br>
  <form method="POST">
    <input type="text" name="user" placeholder="Username" required="">
    <input type="password" name="pass" placeholder="Password" required="">
    <input type="submit" name="login" class="login login-submit" value="login">
  </form>
    
  <div class="login-help">
    <a href="clientsignup.php">Register</a> • <a href="recoverpassword.php">Forgot Password</a>
  </div>
</div>

  <script src='css/jquery.min.js'></script>
<script src='css/jquery-ui.min.js'></script>

  
</body>
</html>
