<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureBank - Modern Banking Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --deep-blue: #0f172a;
            --accent-blue: #3b82f6;
            --light-gray: #f8fafc;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--deep-blue) 0%, var(--primary-blue) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--deep-blue) 0%, var(--primary-blue) 50%, #2563eb 100%);
            min-height: 80vh;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></svg>');
            background-size: 100px 100px;
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .btn-custom {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-light-custom {
            background: white;
            color: var(--primary-blue);
            border: none;
        }
        
        .btn-light-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            background: var(--light-gray);
        }
        
        .btn-outline-custom {
            border: 2px solid white;
            color: white;
            background: transparent;
        }
        
        .btn-outline-custom:hover {
            background: white;
            color: var(--primary-blue);
        }
        
        .feature-card {
            border: none;
            border-radius: 20px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--accent-blue), var(--primary-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            margin-bottom: 20px;
        }
        
        .stats-section {
            background: var(--light-gray);
        }
        
        .stat-item {
            text-align: center;
            padding: 30px;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-blue);
        }
        
        footer {
            background: var(--deep-blue);
            color: white;
            padding: 40px 0 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="bi bi-shield-lock-fill me-2 fs-4"></i>
                <span class="fw-bold">SecureBank</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#security">Security</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item ms-lg-3">
                            <a href="dashboard.php" class="btn btn-light btn-sm btn-custom">Dashboard</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3">
                            <a href="login.php" class="btn btn-outline-light btn-sm btn-custom me-2">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="register.php" class="btn btn-light btn-sm btn-custom">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">Banking Made Simple, Secure, and Smart</h1>
                    <p class="lead mb-4 opacity-90">Experience the future of banking with military-grade security, instant transactions, and 24/7 access to your finances.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="register.php" class="btn btn-light-custom btn-custom">
                            <i class="bi bi-person-plus me-2"></i>Open Account
                        </a>
                        <a href="#features" class="btn btn-outline-custom btn-custom">
                            <i class="bi bi-play-circle me-2"></i>Learn More
                        </a>
                    </div>
                    <div class="mt-5 d-flex gap-4">
                        <div>
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>256-bit Encryption</span>
                        </div>
                        <div>
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>FDIC Insured</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="text-center">
                        <i class="bi bi-bank2" style="font-size: 200px; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase tracking-wide">Features</h6>
                <h2 class="display-5 fw-bold">Why Choose SecureBank?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card h-100 p-4">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Bank-Grade Security</h4>
                        <p class="text-muted">Advanced encryption and multi-factor authentication protect your assets 24/7. Your security is our priority.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100 p-4">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Instant Transfers</h4>
                        <p class="text-muted">Send and receive money in real-time. No waiting periods, no hidden fees, just seamless transactions.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card h-100 p-4">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Smart Analytics</h4>
                        <p class="text-muted">Track spending patterns, set budgets, and receive personalized insights to grow your wealth.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 stat-item">
                    <div class="stat-number">$2B+</div>
                    <p class="text-muted">Assets Protected</p>
                </div>
                <div class="col-md-4 stat-item">
                    <div class="stat-number">50K+</div>
                    <p class="text-muted">Happy Customers</p>
                </div>
                <div class="col-md-4 stat-item">
                    <div class="stat-number">99.9%</div>
                    <p class="text-muted">Uptime Guarantee</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Security Section -->
    <section id="security" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h6 class="text-primary fw-bold text-uppercase">Security First</h6>
                    <h2 class="display-5 fw-bold mb-4">Your Data is Protected by Industry-Leading Standards</h2>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-primary me-3 fs-5"></i>
                            <span>256-bit AES encryption for all data</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-primary me-3 fs-5"></i>
                            <span>PCI DSS compliant infrastructure</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-primary me-3 fs-5"></i>
                            <span>Real-time fraud monitoring</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-primary me-3 fs-5"></i>
                            <span>Biometric authentication support</span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-shield-lock text-primary" style="font-size: 150px; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-shield-lock-fill me-2"></i>SecureBank</h5>
                    <p class="text-white-50">Secure, modern banking for the digital age. Your trusted financial partner.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="login.php" class="text-white-50 text-decoration-none">Login</a></li>
                        <li><a href="register.php" class="text-white-50 text-decoration-none">Register</a></li>
                        <li><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold mb-3">Contact</h5>
                    <p class="text-white-50"><i class="bi bi-envelope me-2"></i>support@securebank.com</p>
                    <p class="text-white-50"><i class="bi bi-telephone me-2"></i>1-800-SECURE</p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-white-50">
                <small>&copy; 2026 SecureBank. All rights reserved. | Secured by Prepared Statements</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
