<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'HR') {
    header("Location: login.php");
    exit;
}

$applications = getAllApplications($pdo);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applicants</title>
</head>
<body>
    <?php include 'hr_nbar.php'; ?>
    <header>
        <h1>Applicants</h1>
    </header>
    <ul>
        <?php foreach ($applications as $app): ?>
            <li>
                <strong>Applicant:</strong> <?php echo htmlspecialchars($app['applicant_name']); ?><br>
                <strong>Job Title:</strong> <?php echo htmlspecialchars($app['job_title']); ?><br>
                <strong>Status:</strong> <?php echo htmlspecialchars($app['status']); ?><br>

                <!-- Display the resume link -->
                <strong>Resume:</strong> <a href="finalsproject/resumes/<?php echo htmlspecialchars($app['resumes']); ?>" target="_blank">View Resume</a><br>

                <form method="POST" action="core/handleForms.php">
                    <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                    <textarea name="response_message" placeholder="Response Message" required></textarea><br>
                    <button type="submit" name="acceptApplicationBtn">Accept</button>
                    <button type="submit" name="rejectApplicationBtn">Reject</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
