<?php
// verify.php - SecureBank Two-Factor Verification
// Session must exist (user logged in)
session_start();

// Check if user is coming from login (session exists)
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Handle verification submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = isset($_POST['verification_code']) ? $_POST['verification_code'] : '';
    
    // Validate: must be exactly 6 digits
    if (preg_match('/^\d{6}$/', $code)) {
        // Accept any 6-digit code for this development stage
        $_SESSION['verified'] = true;
        unset($_SESSION['login_step']); // Clear login step flag
        
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Please enter a valid 6-digit code.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureBank - Verification</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --deep-blue: #0f172a;
            --glass-white: rgba(255, 255, 255, 0.95);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--deep-blue) 0%, var(--primary-blue) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .verify-card {
            background: var(--glass-white);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-header {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-blue), var(--deep-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(30, 58, 138, 0.3);
        }

        .icon-header i {
            font-size: 2.5rem;
            color: white;
        }

        .card-title {
            color: var(--deep-blue);
            font-weight: 700;
            font-size: 1.75rem;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            color: #64748b;
            text-align: center;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            height: 60px;
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5rem;
            text-align: center;
            color: var(--deep-blue);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
        }

        .form-floating label {
            padding-left: 1.5rem;
            color: #64748b;
        }

        .btn-verify {
            background: linear-gradient(135deg, var(--primary-blue), var(--deep-blue));
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 58, 138, 0.4);
            color: white;
        }

        .btn-verify:active {
            transform: translateY(0);
        }

        .links-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .link-resend {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .link-resend:hover {
            color: var(--deep-blue);
            text-decoration: underline;
        }

        .link-back {
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .link-back:hover {
            color: var(--deep-blue);
        }

        .alert-custom {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #dc2626;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .timer-text {
            text-align: center;
            color: #64748b;
            font-size: 0.85rem;
            margin-top: 1rem;
        }

        .timer-text span {
            color: var(--primary-blue);
            font-weight: 600;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .verify-card {
                padding: 2rem;
                border-radius: 16px;
            }

            .icon-header {
                width: 70px;
                height: 70px;
            }

            .icon-header i {
                font-size: 2rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .form-control {
                font-size: 1.25rem;
                letter-spacing: 0.3rem;
            }
        }

        /* Input number arrows removal */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body>

    <div class="verify-card">
        <!-- Icon Header -->
        <div class="icon-header">
            <i class="bi bi-shield-check"></i>
        </div>

        <!-- Titles -->
        <h2 class="card-title">Verify Your Identity</h2>
        <p class="card-subtitle">
            Enter the 6-digit verification code sent to your registered device.
        </p>

        <!-- Error Display -->
        <?php if ($error): ?>
        <div class="alert-custom">
            <i class="bi bi-exclamation-circle-fill"></i>
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <!-- Verification Form -->
        <form method="POST" action="" autocomplete="off">
            <div class="form-floating">
                <input 
                    type="number" 
                    class="form-control" 
                    id="verification_code" 
                    name="verification_code" 
                    placeholder="000000" 
                    maxlength="6"
                    oninput="javascript: if (this.value.length > 6) this.value = this.value.slice(0, 6);"
                    required
                    autofocus
                >
                <label for="verification_code">6-Digit Code</label>
            </div>

            <button type="submit" class="btn btn-verify">
                <i class="bi bi-arrow-right-circle me-2"></i>Verify & Continue
            </button>
        </form>

        <!-- Timer Display -->
        <div class="timer-text">
            Code expires in <span id="timer">02:59</span>
        </div>

        <!-- Links -->
        <div class="links-container">
            <a href="#" class="link-resend" onclick="resendCode(event)">
                <i class="bi bi-arrow-repeat me-1"></i>Resend Code
            </a>
            <a href="login.php" class="link-back">
                <i class="bi bi-arrow-left me-1"></i>Back to Login
            </a>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Countdown Timer
        let timeLeft = 179; // 2:59 in seconds
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = 
                String(minutes).padStart(2, '0') + ':' + 
                String(seconds).padStart(2, '0');
            
            if (timeLeft > 0) {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            } else {
                timerElement.textContent = 'Expired';
                timerElement.style.color = '#dc2626';
            }
        }

        // Start timer on load
        updateTimer();

        // Resend Code Handler
        function resendCode(e) {
            e.preventDefault();
            // Reset timer
            timeLeft = 179;
            timerElement.style.color = 'var(--primary-blue)';
            updateTimer();
            
            // Visual feedback
            const btn = e.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-circle me-1"></i>Code Sent!';
            btn.style.color = '#16a34a';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.color = '';
            }, 2000);
        }

        // Auto-focus and input handling
        const codeInput = document.getElementById('verification_code');
        
        // Ensure only numbers
        codeInput.addEventListener('keypress', function(e) {
            if (!/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });

        // Submit on Enter when 6 digits entered
        codeInput.addEventListener('input', function() {
            if (this.value.length === 6) {
                this.form.submit();
            }
        });
    </script>
</body>
</html>
