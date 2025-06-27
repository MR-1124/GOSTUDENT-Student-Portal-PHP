<?php
require_once '../../includes/db.php';
require_once '../../includes/functions.php';
checkStudent();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_id = $_POST['quiz_id'];
    $student_id = $_SESSION['user_id'];

    // Check if already submitted
    $stmt = $pdo->prepare("SELECT * FROM quiz_submissions WHERE quiz_id = ? AND student_id = ?");
    $stmt->execute([$quiz_id, $student_id]);
    if ($stmt->fetch()) {
        $error = "You have already submitted this quiz!";
    } else {
        $answers = [];
        $score = 0;
        $totalQuestions = 0;

        $qStmt = $pdo->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ?");
        $qStmt->execute([$quiz_id]);
        while ($question = $qStmt->fetch()) {
            $totalQuestions++;
            $answer = $_POST['question' . $question['id']] ?? null;
            $answers[$question['id']] = $answer;
            if ($answer == $question['correct_option']) {
                $score++;
            }
        }

        $finalScore = ($score / $totalQuestions) * 100;
        $answersJson = json_encode($answers);

        $stmt = $pdo->prepare("INSERT INTO quiz_submissions (quiz_id, student_id, answers, score) VALUES (?, ?, ?, ?)");
        $stmt->execute([$quiz_id, $student_id, $answersJson, $finalScore]);

        $gStmt = $pdo->prepare("INSERT INTO grades (student_id, quiz_id, grade, teacher_id) VALUES (?, ?, ?, ?)");
        $gStmt->execute([$student_id, $quiz_id, $finalScore, 1]); // Assuming teacher_id 1 for simplicity

        header("Location: quizzes.php");
        exit;
    }
}
?>
<?php require_once '../../includes/header.php'; ?>
<h4>Error</h4>
<p><?php echo $error; ?></p>
<a href="quizzes.php" class="btn">Back to Quizzes</a>
<?php require_once '../../includes/footer.php'; ?>