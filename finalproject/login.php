<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>


<!DOCTYPE html>
<html>
<head>
    <title>FindHire Login</title>
</head>
<body>
    <h1>Welcome to FindHire</h1>
    <form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username" required>
		</p>
		<p>
			<label for="password">Password</label>
			<input type="password" name="password" required>
			<input type="submit" name="loginUserBtn" value="Login">
		</p>
	</form>
    <p>Don’t have an account? <a href="register.php">Register here</a></p>
</body>
</html>