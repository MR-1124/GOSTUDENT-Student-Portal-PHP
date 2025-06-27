<?php
require_once '../../includes/db.php';
require_once '../../includes/functions.php';
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
        if ($_FILES['assignment_file']['error'] == 0) {
            $fileName = uploadFile($_FILES['assignment_file']);
            if ($fileName) {
                $stmt = $pdo->prepare("INSERT INTO assignment_submissions (assignment_id, student_id, file_path) VALUES (?, ?, ?)");
                $stmt->execute([$assignment_id, $student_id, $fileName]);
                header("Location: assignments.php");
                exit;
            } else {
                $error = "File upload failed!";
            }
        } else {
            $error = "Invalid file!";
        }
    }
}
?>
<?php require_once '../../includes/header.php'; ?>
<h4>Error</h4>
<p><?php echo $error; ?></p>
<a href="assignments.php" class="btn">Back to Assignments</a>
<?php require_once '../../includes/footer.php'; ?>