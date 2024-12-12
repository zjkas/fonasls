<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Ensure the user is logged in as Applicant
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    $job = getJobPostById($pdo, $job_id); // Fetch job details based on job_id
} else {
    header("Location: view_jobs.php"); // Redirect if job_id is not provided
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['resume'])) {
    // Process the application form
    $cover_letter = $_POST['cover_letter'];
    $resume = $_FILES['resume'];

    // Check if the resume is in PDF format
    if ($resume['type'] == 'application/pdf' && $resume['error'] == 0) {
        // Define the folder path to store resumes
        $resume_folder = 'resumes/';

        // Ensure the folder exists, create it if not
        if (!is_dir($resume_folder)) {
            mkdir($resume_folder, 0777, true);
        }

        // Generate a unique file name for the resume to avoid overwriting
        $resume_filename = uniqid() . '-' . basename($resume['name']);
        $resume_path = $resume_folder . $resume_filename;

        // Move the uploaded resume to the resumes folder
        move_uploaded_file($resume['tmp_name'], $resume_path);

        // Save the application to the database
        $applicationStatus = applyToJob($pdo, $_SESSION['user_id'], $job_id, $resume_path, $cover_letter);

        if ($applicationStatus) {
            $_SESSION['message'] = "Your application has been submitted successfully!";
            header("Location: view_jobs.php");
            exit;
        } else {
            $_SESSION['message'] = "There was an error while submitting your application.";
        }
    } else {
        $_SESSION['message'] = "Please upload a valid PDF resume.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
</head>
<body>
    <?php include 'applicant_nbar.php'; ?>
    <h1>Apply for Job: <?php echo htmlspecialchars($job['title']); ?></h1>

    <form action="apply_job.php?job_id=<?php echo $job_id; ?>" method="POST" enctype="multipart/form-data">
        <label for="cover_letter">Cover Letter:</label><br>
        <textarea name="cover_letter" id="cover_letter" rows="4" required></textarea><br>

        <label for="resume">Upload Resume (PDF only):</label><br>
        <input type="file" name="resume" accept="application/pdf" required><br><br>

        <button type="submit">Submit Application</button>
    </form>

    <a href="view_jobs.php">Back to Job List</a>
</body>
</html>
