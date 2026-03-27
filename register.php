<?php
session_start();
require_once 'db.php';

$error = '';
$success = '';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($username) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $error = 'Username must be between 3 and 50 characters.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        $conn = getDBConnection();
        if (!$conn) {
            $error = 'Database connection failed.';
        } else {
            // SECURE: Check if username exists using prepared statement
            $check_sql = "SELECT id FROM users WHERE username = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("s", $username);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            
            if ($check_result->num_rows > 0) {
                $error = 'Username already exists. Please choose another.';
            } else {
                // SECURE: Hash password using bcrypt
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                
                // SECURE: Insert new user using prepared statement
                $insert_sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("ss", $username, $hashed_password);
                
                if ($insert_stmt->execute()) {
                    $new_user_id = $insert_stmt->insert_id;
                    
                    // Create account for new user
                    $account_sql = "INSERT INTO accounts (user_id, balance) VALUES (?, 0.00)";
                    $account_stmt = $conn->prepare($account_sql);
                    $account_stmt->bind_param("i", $new_user_id);
                    $account_stmt->execute();
                    
                    $success = 'Registration successful! Please login.';
                } else {
                    $error = 'Registration failed. Please try again.';
                }
                
                $insert_stmt->close();
            }
            
            $check_stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SecureBank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --deep-blue: #0f172a;
        }
        
        body {
            background: linear-gradient(135deg, var(--deep-blue) 0%, var(--primary-blue) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        
        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
        }
        
        .register-header {
            background: linear-gradient(135deg, var(--deep-blue), var(--primary-blue));
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .register-header i {
            font-size: 50px;
            margin-bottom: 15px;
        }
        
        .register-body {
            padding: 40px 30px;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.25);
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--deep-blue), var(--primary-blue));
            border: none;
            color: white;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 58, 138, 0.3);
            color: white;
        }
        
        .login-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="register-container">
                    <div class="register-header">
                        <i class="bi bi-person-plus"></i>
                        <h3 class="fw-bold mb-0">Create Account</h3>
                        <p class="mb-0 opacity-75">Join SecureBank today</p>
                    </div>
                    <div class="register-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <?php echo htmlspecialchars($success); ?>
                            </div>
                            <div class="text-center mt-3">
                                <a href="login.php" class="btn btn-outline-primary">Proceed to Login</a>
                            </div>
                        <?php else: ?>
                            <form method="POST" action="" autocomplete="off">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required minlength="3" maxlength="50">
                                    <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                                </div>
                                
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required minlength="6">
                                    <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                                </div>
                                
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                    <label for="confirm_password"><i class="bi bi-lock-fill me-2"></i>Confirm Password</label>
                                </div>
                                
                                <button type="submit" class="btn btn-register mb-3">
                                    <i class="bi bi-person-plus me-2"></i>Register
                                </button>
                            </form>
                            
                            <div class="text-center">
                                <p class="text-muted mb-0">Already have an account? <a href="login.php" class="login-link">Login here</a></p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="text-center mt-3">
                            <a href="index.php" class="text-muted text-decoration-none small">
                                <i class="bi bi-arrow-left me-1"></i>Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
