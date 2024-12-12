<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fetch messages based on the role (Applicant or HR)
if ($_SESSION['role'] === 'Applicant') {
    $messages = getMessagesForApplicant($pdo, $_SESSION['user_id']);
} else if ($_SESSION['role'] === 'HR') {
    $messages = getMessagesForHR($pdo, $_SESSION['user_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
</head>
<body>  
    <?php 
    // Include the appropriate navigation bar based on the user's role
    if ($_SESSION['role'] === 'HR') {
        include 'hr_nbar.php'; 
    } elseif ($_SESSION['role'] === 'Applicant') {
        include 'applicant_nbar.php'; 
    }
    ?>
    
    <h1>Your Messages</h1>

    <ul>
        <?php foreach ($messages as $msg): ?>
            <li>
                <strong>From: </strong><?php echo htmlspecialchars($msg['sender_name']); ?><br>
                <strong>Message: </strong><?php echo htmlspecialchars($msg['message_body']); ?><br>
                <strong>Sent On: </strong><?php echo htmlspecialchars($msg['created_at']); ?><br><br>

                <!-- If HR is viewing, allow reply -->
                <?php if ($_SESSION['role'] === 'HR'): ?>
                    <form action="reply.php" method="GET">
                        <input type="hidden" name="message_id" value="<?php echo $msg['id']; ?>">
                        <button type="submit">Reply</button>
                    </form>
                <?php endif; ?>

                <!-- If Applicant is viewing, allow reply -->
                <?php if ($_SESSION['role'] === 'Applicant'): ?>
                    <form action="reply.php" method="GET">
                        <input type="hidden" name="message_id" value="<?php echo $msg['id']; ?>">
                        <button type="submit">Reply</button>
                    </form>
                <?php endif; ?>

            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
