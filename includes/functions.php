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

function uploadFile($file, $uploadDir = null, $fileType = 'image') {
    // Get the root directory of the project (2 levels up from includes/)
    $rootDir = dirname(dirname(__FILE__));
    
    // Use absolute path
    if ($uploadDir === null) {
        $uploadDir = $rootDir . '/assets/uploads/';
    }
    
    // Create directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Validate file is actually uploaded
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return false;
    }
    
    // Define allowed types based on file type parameter
    if ($fileType === 'image') {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB for images
    } elseif ($fileType === 'document') {
        $allowedTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/plain',
            'application/zip',
            'application/x-zip-compressed'
        ];
        $maxSize = 10 * 1024 * 1024; // 10MB for documents
    } else {
        // Allow all common file types
        $allowedTypes = [
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp',
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
            'application/zip'
        ];
        $maxSize = 10 * 1024 * 1024; // 10MB
    }
    
    // Validate file type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $detectedType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    
    if (!in_array($detectedType, $allowedTypes)) {
        return false;
    }
    
    // Validate file size
    if ($file['size'] > $maxSize) {
        return false;
    }
    
    // Generate unique filename
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileName = uniqid() . '_' . time() . '.' . $extension;
    $targetPath = $uploadDir . $fileName;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $fileName;
    }
    
    return false;
}