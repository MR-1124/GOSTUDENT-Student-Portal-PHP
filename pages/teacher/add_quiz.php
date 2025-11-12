<?php
require_once '../../includes/db.php';
require_once '../../includes/functions.php';

if (!isLoggedIn()) {
    header("Location: ../../login.php");
    exit;
}
checkTeacher();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $teacher_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO quizzes (title, teacher_id) VALUES (?, ?)");
    $stmt->execute([$title, $teacher_id]);
    $quiz_id = $pdo->lastInsertId();

    foreach ($_POST['questions'] as $index => $q) {
        $question = $q['question'];
        $options = [$q['option1'], $q['option2'], $q['option3'], $q['option4']];
        $correct_option = $q['correct_option'];

        $stmt = $pdo->prepare("INSERT INTO quiz_questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$quiz_id, $question, $options[0], $options[1], $options[2], $options[3], $correct_option]);
    }

    header("Location: dashboard.php");
    exit;
}

require_once '../../includes/header.php';
?>

<h2 class="mb-xl">Add Quiz</h2>

<div class="row">
    <div class="col col-12">
        <div class="card">
            <div class="card-content">
                <form method="POST">
                    <div class="form-group">
                        <label for="title" class="form-label">Quiz Title</label>
                        <input id="title" type="text" name="title" class="form-input" required autofocus>
                    </div>
                    
                    <div id="questions">
                        <div class="question-block" style="padding: var(--spacing-lg); border: 1px solid var(--color-border); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);">
                            <h4 class="mb-md">Question 1</h4>
                            <div class="form-group">
                                <label class="form-label">Question</label>
                                <input type="text" name="questions[0][question]" class="form-input" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Option 1</label>
                                    <input type="text" name="questions[0][option1]" class="form-input" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Option 2</label>
                                    <input type="text" name="questions[0][option2]" class="form-input" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Option 3</label>
                                    <input type="text" name="questions[0][option3]" class="form-input" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Option 4</label>
                                    <input type="text" name="questions[0][option4]" class="form-input" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Correct Option</label>
                                <select name="questions[0][correct_option]" class="form-select" required>
                                    <option value="" disabled selected>Choose correct option</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                    <option value="4">Option 4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-secondary mb-lg" onclick="addQuestion()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Question
                    </button>
                    
                    <div class="flex gap-sm">
                        <button type="submit" class="btn btn-primary">Create Quiz</button>
                        <a href="dashboard.php" class="btn btn-ghost">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-md);
}
@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
let questionCount = 1;
function addQuestion() {
    const questionsDiv = document.getElementById('questions');
    const questionDiv = document.createElement('div');
    questionDiv.className = 'question-block';
    questionDiv.style.cssText = 'padding: var(--spacing-lg); border: 1px solid var(--color-border); border-radius: var(--radius-md); margin-bottom: var(--spacing-lg);';
    questionDiv.innerHTML = `
        <h4 class="mb-md">Question ${questionCount + 1}</h4>
        <div class="form-group">
            <label class="form-label">Question</label>
            <input type="text" name="questions[${questionCount}][question]" class="form-input" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Option 1</label>
                <input type="text" name="questions[${questionCount}][option1]" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Option 2</label>
                <input type="text" name="questions[${questionCount}][option2]" class="form-input" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Option 3</label>
                <input type="text" name="questions[${questionCount}][option3]" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Option 4</label>
                <input type="text" name="questions[${questionCount}][option4]" class="form-input" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Correct Option</label>
            <select name="questions[${questionCount}][correct_option]" class="form-select" required>
                <option value="" disabled selected>Choose correct option</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
                <option value="4">Option 4</option>
            </select>
        </div>
    `;
    questionsDiv.appendChild(questionDiv);
    questionCount++;
}
</script>

<?php require_once '../../includes/footer.php'; ?>
