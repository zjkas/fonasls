<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'HR') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
</head>
<body>
    <?php include 'hr_nbar.php'; ?>
    <header>
        <h1>Welcome HR: <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    </header>
    <nav>
        <form action="add_job_post.php" method="GET" style="display: inline;">
            <button type="submit">Add Job Post</button>
        </form>
        <form action="view_applicants.php" method="GET" style="display: inline;">
            <button type="submit">View Applicants</button>
        </form>
        <form action="view_job_posts.php" method="GET" style="display: inline;">
            <button type="submit">View My Job Posts</button>
        </form>
        <form action="hr_messages.php" method="GET" style="display: inline;">
            <button type="submit">Messages</button>
        </form>
    </nav>
</body>
</html>
