<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Ensure the user is logged in as Applicant
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login.php");
    exit;
}

// Get all job posts with HR details
$jobs = getAllJobPosts($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
</head>
<body>
    <?php include 'applicant_nbar.php'; ?>
    <h1>Available Job Posts</h1>

    <ul>
        <?php foreach ($jobs as $job): ?>
            <li>
                <strong><?php echo htmlspecialchars($job['title']); ?></strong><br>
                <p><?php echo htmlspecialchars($job['description']); ?></p>
                <p><strong>Posted by:</strong> <?php echo htmlspecialchars($job['hr_username']); ?></p>
                <a href="apply_job.php?job_id=<?php echo $job['id']; ?>">Apply</a>
            </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>
