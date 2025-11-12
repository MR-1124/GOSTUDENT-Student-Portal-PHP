<?php
require_once '../../includes/header.php';
checkStudent();
?>

<h2 class="mb-xl">Quizzes</h2>

<div class="row">
    <?php
    $stmt = $pdo->query("SELECT * FROM quizzes");
    while ($row = $stmt->fetch()) {
        $subStmt = $pdo->prepare("SELECT * FROM quiz_submissions WHERE quiz_id = ? AND student_id = ?");
        $subStmt->execute([$row['id'], $_SESSION['user_id']]);
        $submitted = $subStmt->fetch();

        echo '<div class="col col-6">';
        echo '<div class="card">';
        echo '<div class="card-content">';
        echo '<h3 class="card-title">' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p class="text-muted">Test your knowledge</p>';
        echo '</div>';
        echo '<div class="card-action">';
        if ($submitted) {
            echo '<span class="badge badge-success">Completed</span>';
        } else {
            echo '<button onclick="openModal(\'modal' . $row['id'] . '\')" class="btn btn-primary">Take Quiz</button>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        
        if (!$submitted) {
            echo '<div id="modal' . $row['id'] . '" class="modal" style="display: none; max-width: 800px;">';
            echo '<div class="modal-header">';
            echo '<h3 class="modal-title">' . htmlspecialchars($row['title']) . '</h3>';
            echo '</div>';
            echo '<div class="modal-content">';
            echo '<form method="POST" action="submit_quiz.php" onsubmit="return confirmSubmission()">';
            echo '<input type="hidden" name="quiz_id" value="' . $row['id'] . '">';
            
            $qStmt = $pdo->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ?");
            $qStmt->execute([$row['id']]);
            $questionNum = 1;
            while ($question = $qStmt->fetch()) {
                echo '<div class="form-group">';
                echo '<label class="form-label font-semibold">Question ' . $questionNum . ': ' . htmlspecialchars($question['question']) . '</label>';
                for ($i = 1; $i <= 4; $i++) {
                    echo '<div style="padding: var(--spacing-sm) 0;">';
                    echo '<label style="display: flex; align-items: center; gap: var(--spacing-sm); cursor: pointer;">';
                    echo '<input name="question' . $question['id'] . '" type="radio" value="' . $i . '" required style="width: 18px; height: 18px;" />';
                    echo '<span>' . htmlspecialchars($question['option' . $i]) . '</span>';
                    echo '</label>';
                    echo '</div>';
                }
                echo '</div>';
                $questionNum++;
            }
            
            echo '<div class="modal-footer">';
            echo '<button type="button" onclick="closeModal(\'modal' . $row['id'] . '\')" class="btn btn-ghost">Cancel</button>';
            echo '<button type="submit" class="btn btn-primary">Submit Quiz</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '<div id="overlay' . $row['id'] . '" class="modal-overlay" style="display: none;" onclick="closeModal(\'modal' . $row['id'] . '\')"></div>';
        }
    }
    ?>
</div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'block';
    document.getElementById('overlay' + id.replace('modal', '')).style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.getElementById('overlay' + id.replace('modal', '')).style.display = 'none';
    document.body.style.overflow = 'auto';
}

function confirmSubmission() {
    return confirm("Are you sure you want to submit this quiz? You can only submit once.");
}
</script>

<?php require_once '../../includes/footer.php'; ?>