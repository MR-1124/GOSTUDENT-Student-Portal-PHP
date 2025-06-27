<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $role = $_POST['role'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, name, email, phone, address, dob) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$username, $password, $role, $name, $email, $phone, $address, $dob]);
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - GOSTUDENT</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title center-align">Register</span>
                        <?php if (isset($error)): ?>
                            <p class="red-text center-align"><?php echo $error; ?></p>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input id="username" type="text" name="username" required>
                                    <label for="username">Username</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="password" type="password" name="password" required>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input id="name" type="text" name="name" required>
                                    <label for="name">Full Name</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="email" type="email" name="email" required>
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input id="phone" type="text" name="phone">
                                    <label for="phone">Phone Number</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input id="dob" type="date" name="dob">
                                    <label for="dob">Date of Birth</label>
                                </div>
                            </div>
                            <div class="input-field col s12">
                                <textarea id="address" class="materialize-textarea" name="address"></textarea>
                                <label for="address">Address</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="role" required>
                                    <option value="" disabled selected>Choose your role</option>
                                    <option value="student">Student</option>
                                    <option value="teacher">Teacher</option>
                                </select>
                                <label>Role</label>
                            </div>
                            <div class="center-align">
                                <button type="submit" class="btn waves-effect waves-light">Register</button>
                            </div>
                        </form>
                        <p class="center-align">Already have an account? <a href="login.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('select');
            M.FormSelect.init(elems);
        });
    </script>
</body>
</html>