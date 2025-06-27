<?php
require_once '../../includes/header.php';
checkTeacher();

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<h4 class="center-align">My Profile</h4>
<div class="row">
    <div class="col s12 m4">
        <div class="card">
            <div class="card-content center-align">
                <?php if ($user['profile_picture']): ?>
                    <img src="assets/uploads/<?php echo $user['profile_picture']; ?>" alt="Profile Picture" class="round-avatar">
                <?php else: ?>
                    <img src="https://via.placeholder.com/150" alt="Default Profile Picture" class="round-avatar">
                <?php endif; ?>
                <h5 class="teal-text"><?php echo htmlspecialchars($user['name']); ?></h5>
                <p><?php echo ucfirst($user['role']); ?></p>
            </div>
        </div>
    </div>
    <div class="col s12 m8">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Personal Details</span>
                <table class="striped">
                    <tr>
                        <th>Username</th>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?php echo htmlspecialchars($user['phone'] ?: 'Not provided'); ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo htmlspecialchars($user['address'] ?: 'Not provided'); ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?php echo $user['dob'] ? $user['dob'] : 'Not provided'; ?></td>
                    </tr>
                    <tr>
                        <th>Joined</th>
                        <td><?php echo $user['created_at']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-action">
                <a href="edit_profile.php" class="btn waves-effect waves-light">Edit Profile</a>
            </div>
        </div>
    </div>
</div>
<?php require_once '../../includes/footer.php'; ?>