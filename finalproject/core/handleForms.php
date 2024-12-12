<?php 

require_once 'dbConfig.php'; 
require_once 'models.php';



if (isset($_POST['registerUserBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!empty($username) && !empty($password) && !empty($role)) {
        $insertQuery = insertNewUser($pdo, $username, $password, $role);

        if ($insertQuery) {
            $_SESSION['message'] = "Registration successful! Please log in.";
            header("Location: ./login.php"); 
            exit;
        } else {
            $_SESSION['message'] = "Registration failed! Username may already exist.";
            header("Location: ./register.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Please ensure all fields are filled out for registration!";
        header("Location: ../register.php");
        exit;
    }
}


if (isset($_POST['loginUserBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $loginQuery = loginUser($pdo, $username, $password);

        if ($loginQuery) {
            if ($_SESSION['role'] === 'HR') {
                header("Location: ../hr_dashboard.php"); // Redirect HR users
            } else if ($_SESSION['role'] === 'Applicant') {
                header("Location: ../applicant_dashboard.php"); // Redirect Applicants
            }
            exit;
        } else {
            header("Location: ../login.php");
            exit;
        }
    } else {
        $_SESSION['message'] = "Please fill in all fields to log in.";
        header("Location: ../login.php");
        exit;
    }
}

if (isset($_POST['addJobPostBtn'])) {
    $title = $_POST['job_title'];
    $description = $_POST['job_description'];
    $qualifications = $_POST['job_qualifications'];
    $createdBy = $_SESSION['user_id'];

    $sql = "INSERT INTO job_posts (title, description, qualifications, created_by) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $description, $qualifications, $createdBy]);
    header("Location: ../hr_dashboard.php");
    exit;
}

if (isset($_POST['deleteJobPostBtn'])) {
    $jobId = $_POST['job_id'];

    $sql = "DELETE FROM job_posts WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$jobId]);
    header("Location: ../hr_dashboard.php");
    exit;
}

if (isset($_POST['acceptApplicationBtn']) || isset($_POST['rejectApplicationBtn'])) {
    $applicationId = $_POST['application_id'];
    $status = isset($_POST['acceptApplicationBtn']) ? 'Accepted' : 'Rejected';

    $sql = "UPDATE applications SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$status, $applicationId]);
    header("Location: ../hr_dashboard.php");
    exit;
}






?>

