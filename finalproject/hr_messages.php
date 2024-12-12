<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Ensure the user is logged in as HR
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'HR') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_body = $_POST['message'];
    $receiver_id = $_POST['applicant_id']; // The applicant's user ID

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

// Get the list of applicants
$applicantList = getApplicantList($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Applicant</title>
</head>
<body>
    <?php include 'hr_nbar.php'; ?>
    <h1>Message Applicant</h1>

    <form action="hr_messages.php" method="POST">
        <label for="applicant_id">Select Applicant:</label><br>
        <select name="applicant_id" required>
            <?php foreach ($applicantList as $applicant): ?>
                <option value="<?php echo $applicant['id']; ?>"><?php echo htmlspecialchars($applicant['username']); ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="message">Your Message:</label><br>
        <textarea name="message" id="message" rows="4" required></textarea><br><br>

        <button type="submit">Send Message</button>
    </form>

    <!-- Button to view all messages -->
    <form action="view_messages.php" method="GET" style="display: inline;">
        <button type="submit">View Messages</button>
    </form>
</body>
</html>
