<?php
require_once '../../includes/header.php';
checkStudent();
?>

<h2 class="mb-xl">Grades</h2>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">All Grades</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Assignment/Quiz</th>
                        <th>Grade</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->prepare("SELECT g.grade, a.title AS assignment_title, q.title AS quiz_title, s.feedback
                                           FROM grades g
                                           LEFT JOIN assignments a ON g.assignment_id = a.id
                                           LEFT JOIN quizzes q ON g.quiz_id = q.id
                                           LEFT JOIN assignment_submissions s ON g.assignment_id = s.assignment_id AND g.student_id = s.student_id
                                           WHERE g.student_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    $hasGrades = false;
                    while ($row = $stmt->fetch()) {
                        $hasGrades = true;
                        $title = $row['assignment_title'] ?: $row['quiz_title'];
                        $feedback = $row['feedback'] ? htmlspecialchars($row['feedback']) : 'No feedback';
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($title) . '</td>';
                        echo '<td><span class="badge badge-primary">' . $row['grade'] . '</span></td>';
                        echo '<td>' . $feedback . '</td>';
                        echo '</tr>';
                    }
                    if (!$hasGrades) {
                        echo '<tr><td colspan="3" class="text-center text-muted">No grades available yet</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>
