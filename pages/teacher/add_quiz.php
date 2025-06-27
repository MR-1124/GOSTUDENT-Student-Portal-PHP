<?php
require_once '../../includes/header.php';
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
?>
<h4>Add Quiz</h4>
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <form method="POST">
                    <div class="input-field">
                        <input id="title" type="text" name="title" required>
                        <label for="title">Quiz Title</label>
                    </div>
                    <div id="questions">
                        <div class="question">
                            <div class="input-field">
                                <input type="text" name="questions[0][question]" required>
                                <label>Question 1</label>
                            </div>
                            <div class="input-field">
                                <input type="text" name="questions[0][option1]" required>
                                <label>Option 1</label>
                            </div>
                            <div class="input-field">
                                <input type="text" name="questions[0][option2]" required>
                                <label>Option 2</label>
                            </div>
                            <div class="input-field">
                                <input type="text" name="questions[0][option3]" required>
                                <label>Option 3</label>
                            </div>
                            <div class="input-field">
                                <input type="text" name="questions[0][option4]" required>
                                <label>Option 4</label>
                            </div>
                            <div class="input-field">
                                <select name="questions[0][correct_option]" required>
                                    <option value="" disabled selected>Choose correct option</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                    <option value="4">Option 4</option>
                                </select>
                                <label>Correct Option</label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn" onclick="addQuestion()">Add Question</button>
                    <button type="submit" class="btn">Create Quiz</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
let questionCount = 1;
function addQuestion() {
    const questionsDiv = document.getElementById('questions');
    const questionDiv = document.createElement('div');
    questionDiv.className = 'question';
    questionDiv.innerHTML = `
        <div class="input-field">
            <input type="text" name="questions[${questionCount}][question]" required>
            <label>Question ${questionCount + 1}</label>
        </div>
        <div class="input-field">
            <input type="text" name="questions[${questionCount}][option1]" required>
            <label>Option 1</label>
        </div>
        <div class="input-field">
            <input type="text" name="questions[${questionCount}][option2]" required>
            <label>Option 2</label>
        </div>
        <div class="input-field">
            <input type="text" name="questions[${questionCount}][option3]" required>
            <label>Option 3</label>
        </div>
        <div class="input-field">
            <input type="text" name="questions[${questionCount}][option4]" required>
            <label>Option 4</label>
        </div>
        <div class="input-field">
            <select name="questions[${questionCount}][correct_option]" required>
                <option value="" disabled selected>Choose correct option</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
                <option value="4">Option 4</option>
            </select>
            <label>Correct Option</label>
        </div>
    `;
    questionsDiv.appendChild(questionDiv);
    questionCount++;
    M.FormSelect.init(document.querySelectorAll('select'));
}
</script>
<?php require_once '../../includes/footer.php'; ?>