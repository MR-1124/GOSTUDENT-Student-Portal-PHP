<?php
require_once '../../includes/header.php';
checkStudent();

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $profile_picture = $user['profile_picture'];

    if ($_FILES['profile_picture']['error'] == 0) {
        $fileName = uploadFile($_FILES['profile_picture']);
        if ($fileName) {
            $profile_picture = $fileName;
        } else {
            $error = "Profile picture upload failed!";
        }
    }

    if (!isset($error)) {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, phone = ?, address = ?, dob = ?, profile_picture = ? WHERE id = ?");
        $stmt->execute([$name, $email, $phone, $address, $dob, $profile_picture, $_SESSION['user_id']]);
        header("Location: profile.php");
        exit;
    }
}
?>
<h4>Edit Profile</h4>
<div class="row">
    <div class="col s12 m8 offset-m2">
        <div class="card">
            <div class="card-content">
                <?php if (isset($error)): ?>
                    <p class="red-text"><?php echo $error; ?></p>
                <?php endif; ?>
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col s12 m6">
                            <div class="input-field">
                                <input id="name" type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                <label for="name">Full Name</label>
                            </div>
                        </div>
                        <div class="col s12 m6">
                            <div class="input-field">
                                <input id="email" type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m6">
                            <div class="input-field">
                                <input id="phone" type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                                <label for="phone">Phone Number</label>
                            </div>
                        </div>
                        <div class="col s12 m6">
                            <div class="input-field">
                                <input id="dob" type="date" name="dob" value="<?php echo $user['dob']; ?>">
                                <label for="dob">Date of Birth</label>
                            </div>
                        </div>
                    </div>
                    <div class="input-field">
                        <textarea id="address" class="materialize-textarea" name="address"><?php echo htmlspecialchars($user['address']); ?></textarea>
                        <label for="address">Address</label>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Profile Picture</span>
                            <input type="file" name="profile_picture" accept="image/*">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <button type="submit" class="btn waves-effect waves-light">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once '../../includes/footer.php'; ?>