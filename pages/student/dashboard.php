<?php
require_once '../../includes/header.php';
checkStudent();

$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<div class="card-panel teal lighten-4">
    <h4 class="white-text center-align">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h4>
</div>
<div class="row">
    <div class="col s12 m6">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Recent Assignments</span>
                <?php
                $stmt = $pdo->query("SELECT * FROM assignments ORDER BY due_date LIMIT 5");
                while ($row = $stmt->fetch()) {
                    echo '<p>' . htmlspecialchars($row['title']) . ' - Due: ' . $row['due_date'] . '</p>';
                }
                ?>
            </div>
            <div class="card-action">
                <a href="assignments.php" class="btn waves-effect waves-light">View All</a>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Recent Quizzes</span>
                <?php
                $stmt = $pdo->query("SELECT * FROM quizzes ORDER BY created_at DESC LIMIT 5");
                while ($row = $stmt->fetch()) {
                    echo '<p>' . htmlspecialchars($row['title']) . '</p>';
                }
                ?>
            </div>
            <div class="card-action">
                <a href="quizzes.php" class="btn waves-effect waves-light">View All</a>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Recent Notices</span>
                <?php
                $stmt = $pdo->query("SELECT n.title, n.created_at FROM notices n ORDER BY n.created_at DESC LIMIT 5");
                while ($row = $stmt->fetch()) {
                    echo '<p>' . htmlspecialchars($row['title']) . ' - Posted: ' . $row['created_at'] . '</p>';
                }
                ?>
            </div>
            <div class="card-action">
                <a href="notices.php" class="btn waves-effect waves-light">View All</a>
            </div>
        </div>
    </div>
</div>
<?php require_once '../../includes/footer.php'; ?>