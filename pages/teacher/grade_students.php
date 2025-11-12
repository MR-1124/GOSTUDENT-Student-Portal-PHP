<?php
require_once '../../includes/header.php';
checkTeacher();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $submission_id = $_POST['submission_id'];
    $grade = $_POST['grade'];
    $feedback = $_POST['feedback'];
    $student_id = $_POST['student_id'];
    $assignment_id = $_POST['assignment_id'];

    // Verify the submission has not been graded yet
    $stmt = $pdo->prepare("SELECT grade FROM assignment_submissions WHERE id = ?");
    $stmt->execute([$submission_id]);
    $submission = $stmt->fetch();

    if ($submission['grade'] === null) {
        $stmt = $pdo->prepare("UPDATE assignment_submissions SET grade = ?, feedback = ? WHERE id = ?");
        $stmt->execute([$grade, $feedback, $submission_id]);

        $gStmt = $pdo->prepare("INSERT INTO grades (student_id, assignment_id, grade, teacher_id) VALUES (?, ?, ?, ?)");
        $gStmt->execute([$student_id, $assignment_id, $grade, $_SESSION['user_id']]);

        $success = "Assignment graded successfully!";
    } else {
        $error = "This submission has already been graded!";
    }
}
?>

<h2 class="mb-xl">Grade Students</h2>

<?php if (isset($success)): ?>
    <div class="alert alert-success mb-lg">
        <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-error mb-lg">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Assignment Submissions</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Assignment</th>
                        <th>Student</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->prepare("SELECT s.id, a.title, u.name, s.file_path, s.grade, s.feedback, s.student_id, s.assignment_id
                                           FROM assignment_submissions s
                                           JOIN assignments a ON s.assignment_id = a.id
                                           JOIN users u ON s.student_id = u.id
                                           WHERE a.teacher_id = ?
                                           ORDER BY s.grade IS NULL DESC, s.submitted_at DESC");
                    $stmt->execute([$_SESSION['user_id']]);
                    $hasSubmissions = false;
                    while ($row = $stmt->fetch()) {
                        $hasSubmissions = true;
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td><a href="../../assets/uploads/' . htmlspecialchars($row['file_path']) . '" download class="btn btn-outline">Download</a></td>';
                        echo '<td>';
                        if ($row['grade'] !== null) {
                            echo '<span class="badge badge-success">Graded: ' . $row['grade'] . '</span>';
                        } else {
                            echo '<span class="badge badge-warning">Pending</span>';
                        }
                        echo '</td>';
                        echo '<td>';
                        if ($row['grade'] === null) {
                            echo '<button onclick="openModal(\'gradeModal' . $row['id'] . '\')" class="btn btn-primary">Grade</button>';
                            
                            // Grade Modal
                            echo '<div id="gradeModal' . $row['id'] . '" class="modal" style="display: none;">';
                            echo '<div class="modal-header">';
                            echo '<h3 class="modal-title">Grade Assignment</h3>';
                            echo '</div>';
                            echo '<div class="modal-content">';
                            echo '<p class="mb-md"><strong>Assignment:</strong> ' . htmlspecialchars($row['title']) . '</p>';
                            echo '<p class="mb-lg"><strong>Student:</strong> ' . htmlspecialchars($row['name']) . '</p>';
                            echo '<form method="POST">';
                            echo '<input type="hidden" name="submission_id" value="' . $row['id'] . '">';
                            echo '<input type="hidden" name="student_id" value="' . $row['student_id'] . '">';
                            echo '<input type="hidden" name="assignment_id" value="' . $row['assignment_id'] . '">';
                            echo '<div class="form-group">';
                            echo '<label for="grade' . $row['id'] . '" class="form-label">Grade (0-100)</label>';
                            echo '<input type="number" id="grade' . $row['id'] . '" name="grade" class="form-input" step="0.01" min="0" max="100" required>';
                            echo '</div>';
                            echo '<div class="form-group">';
                            echo '<label for="feedback' . $row['id'] . '" class="form-label">Feedback</label>';
                            echo '<textarea id="feedback' . $row['id'] . '" name="feedback" class="form-textarea" rows="4"></textarea>';
                            echo '</div>';
                            echo '<div class="modal-footer">';
                            echo '<button type="button" onclick="closeModal(\'gradeModal' . $row['id'] . '\')" class="btn btn-ghost">Cancel</button>';
                            echo '<button type="submit" class="btn btn-primary">Submit Grade</button>';
                            echo '</div>';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                            echo '<div id="overlaygradeModal' . $row['id'] . '" class="modal-overlay" style="display: none;" onclick="closeModal(\'gradeModal' . $row['id'] . '\')"></div>';
                        } else {
                            echo '<span class="text-muted">Graded</span>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                    
                    if (!$hasSubmissions) {
                        echo '<tr><td colspan="5" class="text-center text-muted">No submissions to grade</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('overlay' + id).style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('overlay' + id).style.display = 'none';
    document.body.style.overflow = 'auto';
}
</script>

<?php require_once '../../includes/footer.php'; ?>
