<?php
require_once '../../includes/header.php';
checkTeacher();

$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<div class="card-panel teal lighten-4">
    <h4 class="white-text center-align">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h4>
</div>
<div class="row">
    <div class="col s12 m6 l4">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Recent Assignments</span>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM assignments WHERE teacher_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$_SESSION['user_id']]);
                while ($row = $stmt->fetch()) {
                    echo '<p>' . htmlspecialchars($row['title']) . ' - Due: ' . $row['due_date'] . '</p>';
                }
                ?>
            </div>
            <div class="card-action">
                <a href="create_assignment.php" class="btn waves-effect waves-light">Create Assignment</a>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l4">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Recent Quizzes</span>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM quizzes WHERE teacher_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$_SESSION['user_id']]);
                while ($row = $stmt->fetch()) {
                    echo '<p>' . htmlspecialchars($row['title']) . '</p>';
                }
                ?>
            </div>
            <div class="card-action">
                <a href="add_quiz.php" class="btn waves-effect waves-light">Add Quiz</a>
            </div>
        </div>
    </div>
    <div class="col s12 m6 l4">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Recent Notices</span>
                <?php
                $stmt = $pdo->prepare("SELECT * FROM notices WHERE teacher_id = ? ORDER BY created_at DESC LIMIT 5");
                $stmt->execute([$_SESSION['user_id']]);
                while ($row = $stmt->fetch()) {
                    echo '<p>' . htmlspecialchars($row['title']) . ' - Posted: ' . $row['created_at'] . '</p>';
                }
                ?>
            </div>
            <div class="card-action">
                <a href="create_notice.php" class="btn waves-effect waves-light">Create Notice</a>
            </div>
        </div>
    </div>
</div>
<?php require_once '../../includes/footer.php'; ?>