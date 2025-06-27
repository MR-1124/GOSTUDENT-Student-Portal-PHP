<?php
require_once '../../includes/header.php';
checkStudent();
?>
<h4>Quizzes</h4>
<div class="row">
    <?php
    $stmt = $pdo->query("SELECT * FROM quizzes");
    while ($row = $stmt->fetch()) {
        // Check if student has already submitted
        $subStmt = $pdo->prepare("SELECT * FROM quiz_submissions WHERE quiz_id = ? AND student_id = ?");
        $subStmt->execute([$row['id'], $_SESSION['user_id']]);
        $submitted = $subStmt->fetch();

        echo '<div class="col s12 m6">';
        echo '<div class="card">';
        echo '<div class="card-content">';
        echo '<span class="card-title">' . htmlspecialchars($row['title']) . '</span>';
        echo '</div>';
        echo '<div class="card-action">';
        if ($submitted) {
            echo '<span class="green-text">Submitted</span>';
        } else {
            echo '<a href="#modal' . $row['id'] . '" class="modal-trigger btn">Take Quiz</a>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        if (!$submitted) {
            echo '<div id="modal' . $row['id'] . '" class="modal">';
            echo '<div class="modal-content">';
            echo '<h4>' . htmlspecialchars($row['title']) . '</h4>';
            echo '<form method="POST" action="submit_quiz.php" onsubmit="return confirmSubmission()">';
            echo '<input type="hidden" name="quiz_id" value="' . $row['id'] . '">';
            $qStmt = $pdo->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ?");
            $qStmt->execute([$row['id']]);
            $questionNum = 1;
            while ($question = $qStmt->fetch()) {
                echo '<p><strong>Question ' . $questionNum . ': ' . htmlspecialchars($question['question']) . '</strong></p>';
                for ($i = 1; $i <= 4; $i++) {
                    echo '<p><label>';
                    echo '<input name="question' . $question['id'] . '" type="radio" value="' . $i . '" required />';
                    echo '<span>' . htmlspecialchars($question['option' . $i]) . '</span>';
                    echo '</label></p>';
                }
                $questionNum++;
            }
            echo '<button type="submit" class="btn">Submit Quiz</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
</div>
<script>
function confirmSubmission() {
    return confirm("Are you sure you want to submit this quiz? You can only submit once.");
}
</script>
<?php require_once '../../includes/footer.php'; ?>