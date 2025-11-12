<?php
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}
checkStudent();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $assignment_id = $_POST['assignment_id'];
    $student_id = $_SESSION['user_id'];

    // Check if already submitted
    $stmt = $pdo->prepare("SELECT * FROM assignment_submissions WHERE assignment_id = ? AND student_id = ?");
    $stmt->execute([$assignment_id, $student_id]);
    if ($stmt->fetch()) {
        $error = "You have already submitted this assignment!";
    } else {
        if (isset($_FILES['assignment_file']) && $_FILES['assignment_file']['error'] == 0) {
            $fileName = uploadFile($_FILES['assignment_file'], null, 'document');
            if ($fileName) {
                $stmt = $pdo->prepare("INSERT INTO assignment_submissions (assignment_id, student_id, file_path) VALUES (?, ?, ?)");
                $stmt->execute([$assignment_id, $student_id, $fileName]);
                header("Location: assignments.php");
                exit;
            } else {
                $error = "File upload failed! Please upload a valid document (PDF, DOC, DOCX, TXT, ZIP - max 10MB).";
            }
        } else {
            $errorCode = $_FILES['assignment_file']['error'] ?? 'unknown';
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'File is too large (exceeds server limit)',
                UPLOAD_ERR_FORM_SIZE => 'File is too large (exceeds form limit)',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
            ];
            $error = $errorMessages[$errorCode] ?? "Invalid file! Please select a file to upload.";
        }
    }
}
?>
<?php require_once '../../includes/header.php'; ?>
<h4>Error</h4>
<p><?php echo $error; ?></p>
<a href="assignments.php" class="btn">Back to Assignments</a>
<?php require_once '../../includes/footer.php'; ?>