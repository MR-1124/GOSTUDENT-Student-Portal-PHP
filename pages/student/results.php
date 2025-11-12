<?php
require_once '../../includes/header.php';
checkStudent();
?>

<h2 class="mb-xl">Results</h2>

<div class="card mb-xl">
    <div class="card-content">
        <h3 class="card-title">Quiz Results</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Quiz Title</th>
                        <th>Score</th>
                        <th>Submitted At</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->prepare("SELECT q.title, s.score, s.submitted_at, s.answers, s.quiz_id
                                           FROM quiz_submissions s
                                           JOIN quizzes q ON s.quiz_id = q.id
                                           WHERE s.student_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    while ($row = $stmt->fetch()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                        echo '<td><span class="badge badge-primary">' . $row['score'] . '</span></td>';
                        echo '<td>' . date('M d, Y', strtotime($row['submitted_at'])) . '</td>';
                        echo '<td><button onclick="openModal(\'quizModal' . $row['quiz_id'] . '\')" class="btn btn-outline">View Details</button></td>';
                        echo '</tr>';

                        echo '<div id="quizModal' . $row['quiz_id'] . '" class="modal" style="display: none; max-width: 800px;">';
                        echo '<div class="modal-header">';
                        echo '<h3 class="modal-title">' . htmlspecialchars($row['title']) . ' Details</h3>';
                        echo '</div>';
                        echo '<div class="modal-content">';
                        $answers = json_decode($row['answers'], true);
                        $qStmt = $pdo->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ?");
                        $qStmt->execute([$row['quiz_id']]);
                        $questionNum = 1;
                        while ($question = $qStmt->fetch()) {
                            $selected = $answers[$question['id']] ?? 'Not answered';
                            $correct = $question['correct_option'];
                            $isCorrect = ($selected == $correct);
                            echo '<div style="padding: var(--spacing-md); border: 1px solid var(--color-border); border-radius: var(--radius-md); margin-bottom: var(--spacing-md);">';
                            echo '<p class="font-semibold mb-sm">Question ' . $questionNum . ': ' . htmlspecialchars($question['question']) . '</p>';
                            echo '<p class="mb-sm">Your Answer: ' . htmlspecialchars($question['option' . $selected]) . ' ';
                            echo $isCorrect ? '<span class="badge badge-success">Correct</span>' : '<span class="badge badge-destructive">Incorrect</span>';
                            echo '</p>';
                            if (!$isCorrect) {
                                echo '<p>Correct Answer: ' . htmlspecialchars($question['option' . $correct]) . '</p>';
                            }
                            echo '</div>';
                            $questionNum++;
                        }
                        echo '</div>';
                        echo '<div class="modal-footer">';
                        echo '<button onclick="closeModal(\'quizModal' . $row['quiz_id'] . '\')" class="btn btn-primary">Close</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div id="overlayquizModal' . $row['quiz_id'] . '" class="modal-overlay" style="display: none;" onclick="closeModal(\'quizModal' . $row['quiz_id'] . '\')"></div>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <h3 class="card-title">Assignment Results</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Assignment Title</th>
                        <th>Grade</th>
                        <th>Feedback</th>
                        <th>Submitted At</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->prepare("SELECT a.title, s.grade, s.feedback, s.submitted_at, s.file_path
                                           FROM assignment_submissions s
                                           JOIN assignments a ON s.assignment_id = a.id
                                           WHERE s.student_id = ?");
                    $stmt->execute([$_SESSION['user_id']]);
                    while ($row = $stmt->fetch()) {
                        $feedback = $row['feedback'] ? htmlspecialchars($row['feedback']) : 'No feedback';
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                        echo '<td>' . ($row['grade'] ? '<span class="badge badge-primary">' . $row['grade'] . '</span>' : '<span class="badge badge-secondary">Not graded</span>') . '</td>';
                        echo '<td>' . $feedback . '</td>';
                        echo '<td>' . date('M d, Y', strtotime($row['submitted_at'])) . '</td>';
                        echo '<td><a href="../../assets/uploads/' . htmlspecialchars($row['file_path']) . '" download class="btn btn-outline">Download</a></td>';
                        echo '</tr>';
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
