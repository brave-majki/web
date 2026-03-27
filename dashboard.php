<?php
session_start();
require_once 'db.php';

// SECURITY: Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

$balance = 0.00;
$transactions = [];
$error = '';

$conn = getDBConnection();
if (!$conn) {
    $error = 'Unable to load account data.';
} else {
    // SECURE: Fetch account balance using prepared statement
    $balance_sql = "SELECT total_amount FROM user_transaction_totals WHERE user_id = ?";
    $balance_stmt = $conn->prepare($balance_sql);
    $balance_stmt->bind_param("i", $user_id);
    $balance_stmt->execute();
    $balance_result = $balance_stmt->get_result();
    
    if ($balance_result->num_rows > 0) {
        $account = $balance_result->fetch_assoc();
        $balance = $account['total_amount'];
    }
    $balance_stmt->close();
    
    // SECURE: Fetch transactions using prepared statement with LIMIT
    $trans_sql = "SELECT amount, type, description, transaction_date 
                  FROM transactions 
                  WHERE user_id = ? 
                  ORDER BY transaction_date DESC 
                  LIMIT 10";
    $trans_stmt = $conn->prepare($trans_sql);
    $trans_stmt->bind_param("i", $user_id);
    $trans_stmt->execute();
    $trans_result = $trans_stmt->get_result();
    
    while ($row = $trans_result->fetch_assoc()) {
        $transactions[] = $row;
    }
    $trans_stmt->close();
    $conn->close();
}

// Format currency
function formatCurrency($amount) {
    return '$' . number_format($amount, 2);
}

// Format date
function formatDate($date) {
    return date('M d, Y H:i', strtotime($date));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SecureBank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #1e3a8a;
            --deep-blue: #0f172a;
            --accent-blue: #3b82f6;
            --success-green: #10b981;
            --danger-red: #ef4444;
        }
        
        body {
            background: #f1f5f9;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            color: var(--primary-blue) !important;
            font-weight: 700;
        }
        
        .balance-card {
            background: linear-gradient(135deg, var(--deep-blue) 0%, var(--primary-blue) 100%);
            color: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(30, 58, 138, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .balance-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .balance-amount {
            font-size: 3rem;
            font-weight: 700;
            margin: 20px 0;
        }
        
        .quick-actions {
            margin-top: 30px;
        }
        
        .action-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .action-btn:hover {
            background: rgba(255,255,255,0.3);
            color: white;
            transform: translateY(-2px);
        }
        
        .transactions-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .transactions-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e2e8f0;
            background: #fafafa;
        }
        
        .transaction-item {
            padding: 20px 30px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }
        
        .transaction-item:hover {
            background: #f8fafc;
        }
        
        .transaction-item:last-child {
            border-bottom: none;
        }
        
        .transaction-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 15px;
        }
        
        .credit-icon {
            background: #d1fae5;
            color: var(--success-green);
        }
        
        .debit-icon {
            background: #fee2e2;
            color: var(--danger-red);
        }
        
        .amount-credit {
            color: var(--success-green);
            font-weight: 600;
        }
        
        .amount-debit {
            color: var(--danger-red);
            font-weight: 600;
        }
        
        .user-badge {
            background: #e0e7ff;
            color: var(--primary-blue);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="bi bi-shield-lock-fill me-2 fs-4"></i>
                SecureBank
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <span class="user-badge me-3">
                            <i class="bi bi-person-circle me-1"></i>
                            <?php echo htmlspecialchars($username); ?> 
                            <span class="text-uppercase">(<?php echo htmlspecialchars($role); ?>)</span>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a href="index.php" class="btn btn-outline-primary btn-sm me-2">
                            <i class="bi bi-house me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <div class="row g-4">
            <!-- Balance Card -->
            <div class="col-lg-5">
                <div class="balance-card h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="mb-1 opacity-75">Available Balance</p>
                            <h2 class="balance-amount"><?php echo formatCurrency($balance); ?></h2>
                        </div>
                        <i class="bi bi-wallet2 fs-1 opacity-50"></i>
                    </div>
                    
                    <div class="quick-actions d-flex gap-2 flex-wrap">
                        <button class="action-btn">
                            <i class="bi bi-arrow-up-circle me-2"></i>Transfer
                        </button>
                        <button class="action-btn">
                            <i class="bi bi-arrow-down-circle me-2"></i>Deposit
                        </button>
                        <button class="action-btn">
                            <i class="bi bi-clock-history me-2"></i>History
                        </button>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top border-white-50">
                        <small class="opacity-75">
                            <i class="bi bi-shield-check me-1"></i>
                            Account secured with 256-bit encryption
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Transactions -->
            <div class="col-lg-7">
                <div class="transactions-card h-100">
                    <div class="transactions-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-clock-history me-2 text-primary"></i>
                            Latest Transactions
                        </h5>
                        <span class="badge bg-primary"><?php echo count($transactions); ?> records</span>
                    </div>
                    
                    <div class="transactions-list">
                        <?php if (empty($transactions)): ?>
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>No transactions found</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <div class="transaction-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="transaction-icon <?php echo $transaction['type'] === 'Credit' ? 'credit-icon' : 'debit-icon'; ?>">
                                            <?php if (strpos(strtolower($transaction['description']), 'atm') !== false): ?>
                                                <i class="bi bi-cash-coin"></i>
                                            <?php elseif (strpos(strtolower($transaction['description']), 'salary') !== false): ?>
                                                <i class="bi bi-briefcase"></i>
                                            <?php elseif (strpos(strtolower($transaction['description']), 'grocery') !== false): ?>
                                                <i class="bi bi-cart"></i>
                                            <?php else: ?>
                                                <i class="bi bi-<?php echo $transaction['type'] === 'Credit' ? 'arrow-down-left' : 'arrow-up-right'; ?>"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($transaction['description']); ?></h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                <?php echo formatDate($transaction['transaction_date']); ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="<?php echo $transaction['type'] === 'Credit' ? 'amount-credit' : 'amount-debit'; ?> fs-5">
                                            <?php echo $transaction['type'] === 'Credit' ? '+' : '-'; ?>
                                            <?php echo formatCurrency($transaction['amount']); ?>
                                        </div>
                                        <small class="badge <?php echo $transaction['type'] === 'Credit' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?>">
                                            <?php echo $transaction['type']; ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Account Info -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Account Security</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check text-success fs-4 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Last Login</small>
                                        <span class="fw-bold"><?php echo date('M d, Y H:i'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-key text-primary fs-4 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Password</small>
                                        <span class="fw-bold">Last changed recently</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-envelope-check text-info fs-4 me-3"></i>
                                    <div>
                                        <small class="text-muted d-block">Notifications</small>
                                        <span class="fw-bold">Enabled</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
