<?php
require_once '../../includes/header.php';
checkTeacher();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $teacher_id = $_SESSION['user_id'];
    $image_path = null;

    if ($_FILES['notice_image']['error'] == 0) {
        $image_path = uploadFile($_FILES['notice_image']);
        if (!$image_path) {
            $error = "Invalid file path after upload!";
        }
    }

    if (!isset($error)) {
        $stmt = $pdo->prepare("INSERT INTO notices (title, content, image_path, teacher_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $content, $image_path, $teacher_id]);
        header("Location: dashboard.php");
        exit;
    }
}
?>
<h4 class="center-align">Create Notice</h4>
<div class="center-align">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <?php if (isset($error)): ?>
                    <p class="red-text center-align"><?php echo $error; ?></p>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="title" type="text" name="title" required>
                            <label for="title">Title</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="content" class="materialize-textarea" name="content" required></textarea>
                            <label for="content">Content</label>
                        </div>
                    </div>
                    <div>
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image</span>
                            <input type="file" name="notice_image" accept="image/*">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <div class="center-align">
                        <button type="btn waves-effect waves-light">Post Notice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once '../../includes/footer.php'; ?>