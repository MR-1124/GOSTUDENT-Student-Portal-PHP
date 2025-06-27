<?php
require_once '../../includes/header.php';
checkStudent();
?>
<h4 class="center-align">Results</h4>
<div class="card">
    <div class="card-content">
        <span class="card-title">Quiz Results</span>
        <table class="striped responsive-table">
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
                    echo '<td>' . $row['score'] . '</td>';
                    echo '<td>' . $row['submitted_at'] . '</td>';
                    echo '<td><a href="#quizModal' . $row['quiz_id'] . '" class="modal-trigger btn-small waves-effect waves-light">View Details</a></td>';
                    echo '</tr>';

                    echo '<div id="quizModal' . $row['quiz_id'] . '" class="modal">';
                    echo '<div class="modal-content">';
                    echo '<h4>' . htmlspecialchars($row['title']) . ' Details</h4>';
                    $answers = json_decode($row['answers'], true);
                    $qStmt = $pdo->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ?");
                    $qStmt->execute([$row['quiz_id']]);
                    $questionNum = 1;
                    while ($question = $qStmt->fetch()) {
                        $selected = $answers[$question['id']] ?? 'Not answered';
                        $correct = $question['correct_option'];
                        $status = ($selected == $correct) ? '<span class="green-text">Correct</span>' : '<span class="red-text">Incorrect</span>';
                        echo '<p><strong>Question ' . $questionNum . ': ' . htmlspecialchars($question['question']) . '</strong></p>';
                        echo '<p>Your Answer: ' . htmlspecialchars($question['option' . $selected]) . ' - ' . $status . '</p>';
                        echo '<p>Correct Answer: ' . htmlspecialchars($question['option' . $correct]) . '</p>';
                        $questionNum++;
                    }
                    echo '</div>';
                    echo '<div class="modal-footer">';
                    echo '<a href="#!" class="modal-close btn-flat">Close</a>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-content">
        <span class="card-title">Assignment Results</span>
        <table class="striped responsive-table">
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
                    echo '<td>' . ($row['grade'] ?? 'Not graded') . '</td>';
                    echo '<td>' . $feedback . '</td>';
                    echo '<td>' . $row['submitted_at'] . '</td>';
                    echo '<td><a href="../../assets/uploads/' . $row['file_path'] . '" download class="btn-small waves-effect waves-light">Download</a></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once '../../includes/footer.php'; ?>