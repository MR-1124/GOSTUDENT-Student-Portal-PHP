<?php
require_once '../../includes/header.php';
checkTeacher();
?>

<h2 class="mb-xl">Submissions</h2>

<div class="card mb-xl">
    <div class="card-content">
        <h3 class="card-title">Assignment Submissions</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Assignment</th>
                        <th>Student</th>
                        <th>File</th>
                        <th>Submitted At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->prepare("SELECT a.title, u.name, s.file_path, s.submitted_at, s.grade
                                           FROM assignment_submissions s
                                           JOIN assignments a ON s.assignment_id = a.id
                                           JOIN users u ON s.student_id = u.id
                                           WHERE a.teacher_id = ?
                                           ORDER BY s.submitted_at DESC");
                    $stmt->execute([$_SESSION['user_id']]);
                    $hasSubmissions = false;
                    while ($row = $stmt->fetch()) {
                        $hasSubmissions = true;
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td><a href="../../assets/uploads/' . htmlspecialchars($row['file_path']) . '" download class="btn btn-outline">Download</a></td>';
                        echo '<td>' . date('M d, Y', strtotime($row['submitted_at'])) . '</td>';
                        echo '<td>' . ($row['grade'] !== null ? '<span class="badge badge-success">Graded</span>' : '<span class="badge badge-warning">Pending</span>') . '</td>';
                        echo '</tr>';
                    }
                    
                    if (!$hasSubmissions) {
                        echo '<tr><td colspan="5" class="text-center text-muted">No assignment submissions yet</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Quiz Submissions</h3>
        <div class="table-container">
            <table>
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
                                           WHERE q.teacher_id = ?
                                           ORDER BY s.submitted_at DESC");
                    $stmt->execute([$_SESSION['user_id']]);
                    $hasQuizSubmissions = false;
                    while ($row = $stmt->fetch()) {
                        $hasQuizSubmissions = true;
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td><span class="badge badge-primary">' . $row['score'] . '</span></td>';
                        echo '<td>' . date('M d, Y', strtotime($row['submitted_at'])) . '</td>';
                        echo '</tr>';
                    }
                    
                    if (!$hasQuizSubmissions) {
                        echo '<tr><td colspan="4" class="text-center text-muted">No quiz submissions yet</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
