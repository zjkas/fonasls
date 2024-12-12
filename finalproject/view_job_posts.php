<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'HR') {
    header("Location: login.php");
    exit;
}

// Get HR ID from session
$hrId = $_SESSION['user_id'];

// Fetch job posts created by the HR
$jobPosts = getJobPostsByHR($pdo, $hrId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Job Posts</title>
</head>
<body>
    <?php include 'hr_nbar.php'; ?>
    <header>
        <h1>My Job Posts</h1>
    </header>
    <main>
        <?php if (!empty($jobPosts)): ?>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Qualifications</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jobPosts as $post): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo htmlspecialchars($post['description']); ?></td>
                            <td><?php echo htmlspecialchars($post['qualifications']); ?></td>
                            <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No job posts found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
