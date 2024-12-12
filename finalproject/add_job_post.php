<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'HR') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['job_title'];
    $description = $_POST['job_description'];
    $qualifications = $_POST['job_qualifications'];
    $created_by = $_SESSION['user_id'];

    if (addJobPost($pdo, $title, $description, $qualifications, $created_by)) {
        $_SESSION['message'] = "Job post added successfully!";
    } else {
        $_SESSION['message'] = "Failed to add job post.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job Post</title>
</head>
<body>
    <?php include 'hr_nbar.php'; ?>
    <header>
        <h1>Add Job Post</h1>
    </header>
    <form method="POST" action="">
        <input type="text" name="job_title" placeholder="Job Title" required>
        <textarea name="job_description" placeholder="Job Description" required></textarea>
        <textarea name="job_qualifications" placeholder="Qualifications" required></textarea>
        <button type="submit">Add Job Post</button>
    </form>
</body>
</html>
