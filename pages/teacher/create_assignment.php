<?php
require_once '../../includes/header.php';
checkTeacher();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $teacher_id = $_SESSION['user_id'];
    $fileName = null;

    if ($_FILES['assignment_file']['error'] == 0) {
        $fileName = uploadFile($_FILES['assignment_file']);
    }

    $stmt = $pdo->prepare("INSERT INTO assignments (title, description, due_date, teacher_id, file_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $due_date, $teacher_id, $fileName]);
    header("Location: dashboard.php");
    exit;
}
?>
<h4>Create Assignment</h4>
<div class="row">
    <div class="col s12 m6">
        <div class="card">
            <div class="card-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="input-field">
                        <input id="title" type="text" name="title" required>
                        <label for="title">Title</label>
                    </div>
                    <div class="input-field">
                        <textarea id="description" class="materialize-textarea" name="description"></textarea>
                        <label for="description">Description</label>
                    </div>
                    <div class="input-field">
                        <input id="due_date" type="date" name="due_date" required>
                        <label for="due_date">Due Date</label>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="assignment_file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <button type="submit" class="btn">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once '../../includes/footer.php'; ?>