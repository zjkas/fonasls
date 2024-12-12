<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Get the original message data
if (isset($_GET['message_id'])) {
    $message_id = $_GET['message_id'];
    $message = getMessageById($pdo, $message_id);
} else {
    header("Location: view_messages.php"); // If no message_id, redirect back to messages list
    exit;
}

// Check if the logged-in user is the sender or receiver and set the reply context
if ($_SESSION['role'] === 'HR' && $message['receiver_id'] === $_SESSION['user_id']) {
    // HR replying to applicant's message
    $receiver_id = $message['sender_id']; // The applicant
    $role = 'HR';
} elseif ($_SESSION['role'] === 'Applicant' && $message['receiver_id'] === $_SESSION['user_id']) {
    // Applicant replying to HR's message
    $receiver_id = $message['sender_id']; // The HR
    $role = 'Applicant';
} else {
    // If neither condition is met, redirect back to the messages list
    header("Location: view_messages.php");
    exit;
}

// Handle the reply submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_body = $_POST['message'];

    // Save the reply message
    $messageStatus = sendMessageToHR($pdo, $_SESSION['user_id'], $receiver_id, $message_body);

    if ($messageStatus) {
        $_SESSION['message'] = "Your reply has been sent successfully!";
        header("Location: view_messages.php");
        exit;
    } else {
        $_SESSION['message'] = "There was an error sending your reply.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Message</title>
</head>
<body>
    <?php
    // Include navigation bar based on role
    if ($_SESSION['role'] === 'HR') {
        include 'hr_nbar.php';
    } else {
        include 'applicant_nbar.php';
    }
    ?>

    <h1>Reply to Message</h1>

    <!-- Reply Form -->
    <form action="reply.php?message_id=<?php echo $message_id; ?>" method="POST">
        <label for="message">Your Reply:</label><br>
        <textarea name="message" id="message" rows="4" required></textarea><br><br>

        <button type="submit">Send Reply</button>
    </form>

    <!-- Display the original message -->
    <h3>Original Message</h3>
    <p><strong>From:</strong> <?php echo htmlspecialchars($message['sender_name']); ?></p>
    <p><strong>Message:</strong> <?php echo htmlspecialchars($message['message_body']); ?></p>
</body>
</html>
