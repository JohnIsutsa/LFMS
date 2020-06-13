<?php include 'includes/connection.php' ?>

<!DOCTYPE html>
<html>
<head>
	<title>Home - LFMS</title>
	<link rel="stylesheet" type="text/css" href="./css/login.css">

</head>
<body>
	<div class="navbar">
		<h1>LAW FIRM MANAGEMENT SYSTEM</h1>
	</div>
	<div class="container" id="container">
	    <div class="form-container sign-up-container">
	         <form action="lawyerlogin.php" method="POST">
		        <h1>Lawyer Sign In</h1>
		        <div class="social-container">
		            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
		            <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
		            <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
		        </div>
		        <!--<span>or use your email for registration</span>
		        <input type="email" placeholder="Email" />-->
		        <input type="text" name="user" placeholder="Username" required="" />
		        <input type="password" name="pass" placeholder="Password" required="" />
		        <!--<a href="">Forgot your password?</a>-->
		        <button style="margin-bottom: 10px;" type="submit" name="submit" >Sign In</button>

		        <span>OR</span>

		        <!--<input class="lawyerlogin" type="submit" name="submit" value="Sign In">-->
		        <!--<button class="lawyersignup ghost"><a href="lawyersignup.php">Create Account</a></button>-->
		        <a class="button lawyersignup ghost" href="lawyersignup.php">Create Account</a>
    		</form>


	    </div>
	    <div class="form-container sign-in-container">
	        <form action="clientlogin.php" method="POST">
		        <h1>Client Sign in</h1>
		        <div class="social-container">
		            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
		            <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
		            <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
		        </div>
		        <!--<span>or use your account</span>
		        <input type="email" placeholder="Email" />-->
		        <input type="text" name="user" placeholder="Username" />
		        <input type="password" name="pass" placeholder="Password" />
		        <a href="#">Forgot your password?</a>
		        <button type="submit" name="submit" >Sign In</button>
		        <!--<input class="clientlogin" type="submit" name="submit" value="Sign In">-->
    		</form>
	    </div>
	    <div class="overlay-container">
	       <div class="overlay">
		        <div class="overlay-panel overlay-left">
		            <h1>Welcome!</h1>
		            <p>
		                To access your client portal please sign in to your account
		            </p>
		            <button class="ghost" id="signIn"> Client Sign In</button>
		        </div>
		        <div class="overlay-panel overlay-right">
		            <h1>Hello, Advocate!</h1>
		            <p>
		            To sign in as a lawyer</p>
		            <button class="ghost" id="signUp">Lawyer Sign In</button>
		        </div>
    		</div>
    	</div>
</div>
<script src="./js/main.js"></script>

</body>
</html>