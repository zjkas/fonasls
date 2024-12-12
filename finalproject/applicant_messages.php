<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Ensure the user is logged in as an Applicant
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_body = $_POST['message'];
    $receiver_id = $_POST['hr_id']; // The HR representative's user ID

    // Save the message
    $messageStatus = sendMessageToHR($pdo, $_SESSION['user_id'], $receiver_id, $message_body);

    if ($messageStatus) {
        $_SESSION['message'] = "Your message has been sent successfully!";
        header("Location: view_messages.php");
        exit;
    } else {
        $_SESSION['message'] = "There was an error sending your message.";
    }
}

// Get the list of HR representatives
$hrList = getHRList($pdo);
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

    <form action="applicant_messages.php" method="POST">
        <label for="hr_id">Select HR Representative:</label><br>
        <select name="hr_id" required>
            <?php foreach ($hrList as $hr): ?>
                <option value="<?php echo $hr['id']; ?>"><?php echo htmlspecialchars($hr['username']); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="message">Your Message:</label><br>
        <textarea name="message" id="message" rows="4" required></textarea><br><br>

        <button type="submit">Send Message</button>
    </form>

    <!-- Button to view messages -->
    <br>
    <a href="view_messages.php">
        <button>View Messages</button>
    </a>
</body>
</html>
