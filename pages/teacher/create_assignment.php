<?php
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

// Start session and check authentication BEFORE any output
if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}
checkTeacher();

// Handle POST request BEFORE including header
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $teacher_id = $_SESSION['user_id'];
    $fileName = null;

    if (isset($_FILES['assignment_file']) && $_FILES['assignment_file']['error'] == 0) {
        $fileName = uploadFile($_FILES['assignment_file'], null, 'all');
    }

    $stmt = $pdo->prepare("INSERT INTO assignments (title, description, due_date, teacher_id, file_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $due_date, $teacher_id, $fileName]);
    header("Location: dashboard.php");
    exit;
}

// Now include header for HTML output
require_once '../../includes/header.php';
?>

<h2 class="mb-xl">Create Assignment</h2>

<div class="row">
    <div class="col col-8" style="margin: 0 auto;">
        <div class="card">
            <div class="card-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title" class="form-label">Assignment Title</label>
                        <input id="title" type="text" name="title" class="form-input" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-textarea" rows="6"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input id="due_date" type="date" name="due_date" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="assignment_file" class="form-label">Attachment (Optional)</label>
                        <input type="file" name="assignment_file" id="assignment_file" class="form-input" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.jpg,.jpeg,.png,.gif,.webp">
                        <p class="form-helper">Upload reference materials, instructions, or images (PDF, DOC, Images, etc. - max 10MB)</p>
                    </div>
                    
                    <div class="flex gap-sm" style="margin-top: var(--spacing-lg);">
                        <button type="submit" class="btn btn-primary">Create Assignment</button>
                        <a href="dashboard.php" class="btn btn-ghost">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
