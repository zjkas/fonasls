<?php
require_once 'core/models.php';

// Ensure the user is logged in as Applicant
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Applicant') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Dashboard</title>
</head>
<body>
    <?php include 'applicant_nbar.php'; ?>
    
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    </header>

    <nav>
        <form action="view_jobs.php" method="GET" style="display: inline;">
            <button type="submit">View Available Job Posts</button>
        </form>

        <form action="view_applied_jobs.php" method="GET" style="display: inline;">
            <button type="submit">View Applied Jobs</button>
        </form>

        <form action="applicant_messages.php" method="GET" style="display: inline;">
            <button type="submit">Messages</button>
        </form>
    </nav>

    <section>
        <h2>Dashboard Overview</h2>
        <p>From this dashboard, you can apply for jobs, view your previous applications, and send messages to HR.</p>
    </section>

</body>
</html>
