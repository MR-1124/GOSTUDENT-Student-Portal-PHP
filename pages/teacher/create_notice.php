<?php
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}
checkTeacher();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $teacher_id = $_SESSION['user_id'];
    $image_path = null;

    if (isset($_FILES['notice_image']) && $_FILES['notice_image']['error'] == 0) {
        $image_path = uploadFile($_FILES['notice_image'], null, 'image');
        if (!$image_path) {
            $error = "Invalid image file! Please upload JPG, PNG, GIF, or WEBP (max 5MB).";
        }
    }

    if (!isset($error)) {
        $stmt = $pdo->prepare("INSERT INTO notices (title, content, image_path, teacher_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $content, $image_path, $teacher_id]);
        header("Location: dashboard.php");
        exit;
    }
}

require_once '../../includes/header.php';
?>

<h2 class="mb-xl">Create Notice</h2>

<div class="row">
    <div class="col col-8" style="margin: 0 auto;">
        <div class="card">
            <div class="card-content">
                <?php if (isset($error)): ?>
                    <div class="alert alert-error mb-lg">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title" class="form-label">Notice Title</label>
                        <input id="title" type="text" name="title" class="form-input" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="content" class="form-label">Content</label>
                        <textarea id="content" name="content" class="form-textarea" rows="8" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="notice_image" class="form-label">Image (Optional)</label>
                        <input type="file" name="notice_image" id="notice_image" class="form-input" accept="image/*">
                        <p class="form-helper">Add an image to make your notice more engaging</p>
                    </div>
                    
                    <div class="flex gap-sm" style="margin-top: var(--spacing-lg);">
                        <button type="submit" class="btn btn-primary">Post Notice</button>
                        <a href="dashboard.php" class="btn btn-ghost">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
