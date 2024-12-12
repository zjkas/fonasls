<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="Applicant">Applicant</option>
            <option value="HR">HR</option>
        </select>
        <input type="submit" name="registerUserBtn" value="Register">
    </form>
    <a href="login.php">Go to Login</a>
</body>
</html>