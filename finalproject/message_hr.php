<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';


if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login.php");
    exit;
}

// Get the confirmation message from session (if any)
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message after it is displayed
} else {
    $message = "No message sent yet.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message HR</title>
</head>
<body>
    <?php include 'applicant_nbar.php'; ?>
    <h1>Message HR</h1>

    <p><?php echo htmlspecialchars($message); ?></p>

    <br>

</body>
</html>
