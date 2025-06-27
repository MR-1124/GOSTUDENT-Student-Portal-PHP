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

        header("Location: grade_students.php");
        exit;
    } else {
        $error = "This submission has already been graded!";
    }
}
?>
<h4 class="center-align">Grade Students</h4>
<div class="card">
    <div class="card-content">
        <span class="card-title">Assignment Submissions</span>
        <?php if (isset($error)): ?>
            <p class="red-text center-align"><?php echo $error; ?></p>
        <?php endif; ?>
        <table class="striped responsive-table">
            <thead>
                <tr>
                    <th>Assignment</th>
                    <th>Student</th>
                    <th>File</th>
                    <th>Grade</th>
                    <th>Feedback</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->prepare("SELECT s.id, a.title, u.name, s.file_path, s.grade, s.feedback, s.student_id, s.assignment_id
                                       FROM assignment_submissions s
                                       JOIN assignments a ON s.assignment_id = a.id
                                       JOIN users u ON s.student_id = u.id
                                       WHERE a.teacher_id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                while ($row = $stmt->fetch()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td><a href="../../assets/uploads/' . $row['file_path'] . '" download class="btn-small waves-effect waves-light">Download</a></td>';
                    echo '<td>' . ($row['grade'] !== null ? $row['grade'] : 'Not graded') . '</td>';
                    echo '<td>' . (htmlspecialchars($row['feedback'] ?? 'No feedback')) . '</td>';
                    echo '<td>';
                    if ($row['grade'] === null) {
                        echo '<form method="POST">';
                        echo '<input type="hidden" name="submission_id" value="' . $row['id'] . '">';
                        echo '<input type="hidden" name="student_id" value="' . $row['student_id'] . '">';
                        echo '<input type="hidden" name="assignment_id" value="' . $row['assignment_id'] . '">';
                        echo '<div class="input-field inline">';
                        echo '<input type="number" name="grade" step="0.01" min="0" max="100" required>';
                        echo '<label for="grade">Grade</label>';
                        echo '</div>';
                        echo '<div class="input-field inline">';
                        echo '<textarea name="feedback" class="materialize-textarea"></textarea>';
                        echo '<label for="feedback">Feedback</label>';
                        echo '</div>';
                        echo '<button type="submit" class="btn-small waves-effect waves-light">Grade</button>';
                        echo '</form>';
                    } else {
                        echo '<span class="badge teal-text">Graded</span>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../../includes/footer.php'; ?>