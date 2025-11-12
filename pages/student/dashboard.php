<?php
require_once '../../includes/header.php';
checkStudent();

$stmt = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<div class="welcome-banner">
    <h1>Welcome back, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    <p>Here's what's happening with your courses today</p>
</div>

<div class="row">
    <div class="col col-6">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Recent Assignments</h3>
                <?php
                $stmt = $pdo->query("SELECT * FROM assignments ORDER BY due_date LIMIT 5");
                $assignments = $stmt->fetchAll();
                if ($assignments): ?>
                    <div style="margin-top: var(--spacing-md);">
                        <?php foreach ($assignments as $row): ?>
                            <div style="padding: var(--spacing-md) 0; border-bottom: 1px solid var(--color-border);">
                                <div class="font-semibold"><?php echo htmlspecialchars($row['title']); ?></div>
                                <div class="text-muted" style="font-size: 0.875rem; margin-top: var(--spacing-xs);">
                                    Due: <?php echo date('M d, Y', strtotime($row['due_date'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No assignments available</p>
                <?php endif; ?>
            </div>
            <div class="card-action">
                <a href="assignments.php" class="btn btn-primary">View All Assignments</a>
            </div>
        </div>
    </div>
    
    <div class="col col-6">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Recent Quizzes</h3>
                <?php
                $stmt = $pdo->query("SELECT * FROM quizzes ORDER BY created_at DESC LIMIT 5");
                $quizzes = $stmt->fetchAll();
                if ($quizzes): ?>
                    <div style="margin-top: var(--spacing-md);">
                        <?php foreach ($quizzes as $row): ?>
                            <div style="padding: var(--spacing-md) 0; border-bottom: 1px solid var(--color-border);">
                                <div class="font-semibold"><?php echo htmlspecialchars($row['title']); ?></div>
                                <div class="text-muted" style="font-size: 0.875rem; margin-top: var(--spacing-xs);">
                                    Posted: <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No quizzes available</p>
                <?php endif; ?>
            </div>
            <div class="card-action">
                <a href="quizzes.php" class="btn btn-primary">View All Quizzes</a>
            </div>
        </div>
    </div>
    
    <div class="col col-6">
        <div class="card">
            <div class="card-content">
                <h3 class="card-title">Recent Notices</h3>
                <?php
                $stmt = $pdo->query("SELECT n.title, n.created_at FROM notices n ORDER BY n.created_at DESC LIMIT 5");
                $notices = $stmt->fetchAll();
                if ($notices): ?>
                    <div style="margin-top: var(--spacing-md);">
                        <?php foreach ($notices as $row): ?>
                            <div style="padding: var(--spacing-md) 0; border-bottom: 1px solid var(--color-border);">
                                <div class="font-semibold"><?php echo htmlspecialchars($row['title']); ?></div>
                                <div class="text-muted" style="font-size: 0.875rem; margin-top: var(--spacing-xs);">
                                    Posted: <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No notices available</p>
                <?php endif; ?>
            </div>
            <div class="card-action">
                <a href="notices.php" class="btn btn-primary">View All Notices</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>