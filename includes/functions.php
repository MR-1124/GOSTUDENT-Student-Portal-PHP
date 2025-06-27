<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isStudent() {
    return isLoggedIn() && $_SESSION['role'] == 'student';
}

function isTeacher() {
    return isLoggedIn() && $_SESSION['role'] == 'teacher';
}

function redirectToDashboard() {
    if (isStudent()) {
        header("Location: pages/student/dashboard.php");
    } elseif (isTeacher()) {
        header("Location: pages/teacher/dashboard.php");
    } else {
        header("Location: login.php");
    }
    exit;
}

function checkStudent() {
    if (!isStudent()) {
        header("Location: ../../login.php");
        exit;
    }
}

function checkTeacher() {
    if (!isTeacher()) {
        header("Location: ../../login.php");
        exit;
    }
}

function uploadFile($file, $uploadDir = 'assets/uploads/') {
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $fileName;
    }
    return false;
}
?>