<?php
require_once '../../includes/header.php';
checkTeacher();
?>
<h4>Submissions</h4>
<h5>Assignment Submissions</h5>
<table class="striped">
    <thead>
        <tr>
            <th>Assignment</th>
            <th>Student</th>
            <th>File</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->prepare("SELECT a.title, u.name, s.file_path, s.submitted_at
                               FROM assignment_submissions s
                               JOIN assignments a ON s.assignment_id = a.id
                               JOIN users u ON s.student_id = u.id
                               WHERE a.teacher_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        while ($row = $stmt->fetch()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td><a href="../../assets/uploads/' . $row['file_path'] . '" download>Download</a></td>';
            echo '<td>' . $row['submitted_at'] . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<h5>Quiz Submissions</h5>
<table class="striped">
    <thead>
        <tr>
            <th>Quiz</th>
            <th>Student</th>
            <th>Score</th>
            <th>Submitted At</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $pdo->prepare("SELECT q.title, u.name, s.score, s.submitted_at
                               FROM quiz_submissions s
                               JOIN quizzes q ON s.quiz_id = q.id
                               JOIN users u ON s.student_id = u.id
                               WHERE q.teacher_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        while ($row = $stmt->fetch()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . $row['score'] . '</td>';
            echo '<td>' . $row['submitted_at'] . '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php require_once '../../includes/footer.php'; ?>