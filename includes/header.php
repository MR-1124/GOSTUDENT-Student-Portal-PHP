<?php
require_once 'db.php';
require_once 'functions.php';
if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOSTUDENT</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <nav class="nav-extended">
        <div class="nav-wrapper teal lighten-2">
            <a href="#" class="brand-logo left" style="font-weight: 700; margin-left: 20px;">GOSTUDENT</a>
            <a href="#" data-target="mobile-nav" class="sidenav-trigger right"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <?php if (isStudent()): ?>
                    <li><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                    <li><a href="assignments.php" class="nav-link">Assignments</a></li>
                    <li><a href="quizzes.php" class="nav-link">Quizzes</a></li>
                    <li><a href="notices.php" class="nav-link">Notices</a></li>
                    <li><a href="results.php" class="nav-link">Results</a></li>
                    <li><a href="grades.php" class="nav-link">Grades</a></li>
                    <li><a href="doubts.php" class="nav-link">Doubts</a></li>
                    <li><a href="profile.php" class="nav-link">Profile</a></li>
                    <li><a href="../../logout.php" class="nav-link">Logout</a></li>
                <?php elseif (isTeacher()): ?>
                    <li><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                    <li><a href="manage_students.php" class="nav-link">Manage Students</a></li>
                    <li><a href="create_assignment.php" class="nav-link">Create Assignment</a></li>
                    <li><a href="add_quiz.php" class="nav-link">Add Quiz</a></li>
                    <li><a href="view_submissions.php" class="nav-link">Submissions</a></li>
                    <li><a href="grade_students.php" class="nav-link">Grade Students</a></li>
                    <li><a href="create_notice.php" class="nav-link">Create Notice</a></li>
                    <li><a href="doubts.php" class="nav-link">Doubts</a></li>
                    <li><a href="profile.php" class="nav-link">Profile</a></li>
                    <li><a href="../../logout.php" class="nav-link">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <ul class="sidenav" id="mobile-nav">
        <?php if (isStudent()): ?>
            <li><a href="dashboard.php" class="sidenav-link">Dashboard</a></li>
            <li><a href="assignments.php" class="sidenav-link">Assignments</a></li>
            <li><a href="quizzes.php" class="sidenav-link">Quizzes</a></li>
            <li><a href="notices.php" class="sidenav-link">Notices</a></li>
            <li><a href="results.php" class="sidenav-link">Results</a></li>
            <li><a href="grades.php" class="sidenav-link">Grades</a></li>
            <li><a href="doubts.php" class="sidenav-link">Doubts</a></li>
            <li><a href="profile.php" class="sidenav-link">Profile</a></li>
            <li><a href="../../logout.php" class="sidenav-link">Logout</a></li>
        <?php elseif (isTeacher()): ?>
            <li><a href="dashboard.php" class="sidenav-link">Dashboard</a></li>
            <li><a href="manage_students.php" class="sidenav-link">Manage Students</a></li>
            <li><a href="create_assignment.php" class="sidenav-link">Create Assignment</a></li>
            <li><a href="add_quiz.php" class="sidenav-link">Add Quiz</a></li>
            <li><a href="view_submissions.php" class="sidenav-link">Submissions</a></li>
            <li><a href="grade_students.php" class="sidenav-link">Grade Students</a></li>
            <li><a href="create_notice.php" class="sidenav-link">Create Notice</a></li>
            <li><a href="doubts.php" class="sidenav-link">Doubts</a></li>
            <li><a href="profile.php" class="sidenav-link">Profile</a></li>
            <li><a href="../../logout.php" class="sidenav-link">Logout</a></li>
        <?php endif; ?>
    </ul>
    <div class="container main-content">