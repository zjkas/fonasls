<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';


if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login.php");
    exit;
}

// Get the applicant's ID from the session
$applicant_id = $_SESSION['user_id'];

// Fetch applied jobs for the applicant
$appliedJobs = getAppliedJobs($pdo, $applicant_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied Jobs</title>
</head>
<body>
    <?php include 'applicant_nbar.php'; ?>
    <header>
        <h1>Your Applied Jobs</h1>
    </header>

    <?php if (empty($appliedJobs)): ?>
        <p>You haven't applied to any jobs yet.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($appliedJobs as $job): ?>
                <li>
                    <strong>Job Title:</strong> <?php echo htmlspecialchars($job['title']); ?><br>
                    <strong>Description:</strong> <?php echo nl2br(htmlspecialchars($job['description'])); ?><br>
                    <strong>Status:</strong> <?php echo htmlspecialchars($job['status']); ?><br>
                    <strong>Applied On:</strong> <?php echo htmlspecialchars($job['applied_on']); ?><br>
                    <strong>Resume:</strong> <a href="<?php echo htmlspecialchars($job['resume_path']); ?>" download>Download Resume</a><br>
                    <strong>Cover Letter:</strong> <?php echo nl2br(htmlspecialchars($job['cover_letter'])); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
