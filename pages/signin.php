<?php
require_once '../includes/db_connect.php';
require_once '../includes/session.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = trim($_POST['username']);
$password = $_POST['password'];
if (empty($username) || empty($password)) {
$error = 'Please enter both username and password';
    } else {
// Correct table: app_user
// Correct columns: id, name, password
$stmt = $conn->prepare("SELECT id, name, password FROM app_user WHERE name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
$user = $result->fetch_assoc();
if (password_verify($password, $user['password'])) {
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['name'];
header("Location: dashboard.php");
exit();
            } else {
$error = 'Invalid username or password';
            }
        } else {
$error = 'Invalid username or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In - HOOSHungry</title>
<link rel="stylesheet" href="../assets/styles.css">
<style>
/* Animated background effects */
.auth-container {
    position: relative;
    overflow: hidden;
}

/* Floating gradient orbs */
.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    opacity: 0.6;
    animation: float 20s infinite ease-in-out;
}

.orb-1 {
    width: 400px;
    height: 400px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    top: -200px;
    left: -200px;
    animation-delay: 0s;
}

.orb-2 {
    width: 350px;
    height: 350px;
    background: linear-gradient(135deg, #f093fb, #f5576c);
    bottom: -150px;
    right: -150px;
    animation-delay: 5s;
}

.orb-3 {
    width: 300px;
    height: 300px;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    top: 50%;
    right: -100px;
    animation-delay: 10s;
}

@keyframes float {
    0%, 100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(50px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-30px, 30px) scale(0.9);
    }
}

/* Particle effect */
.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: white;
    border-radius: 50%;
    opacity: 0.3;
    animation: particle-float 15s infinite ease-in-out;
}

@keyframes particle-float {
    0%, 100% {
        transform: translateY(0) translateX(0);
        opacity: 0;
    }
    10% {
        opacity: 0.3;
    }
    90% {
        opacity: 0.3;
    }
    100% {
        transform: translateY(-100vh) translateX(50px);
        opacity: 0;
    }
}

/* Enhanced auth card with glow */
.auth-card {
    position: relative;
    z-index: 10;
    animation: cardEntrance 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.auth-card::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(135deg, #667eea, #764ba2, #f093fb);
    border-radius: 26px;
    opacity: 0;
    transition: opacity 0.5s ease;
    z-index: -1;
    filter: blur(20px);
}

.auth-card:hover::before {
    opacity: 0.6;
}

@keyframes cardEntrance {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Glowing input effects */
.form-group input {
    position: relative;
    transition: all 0.3s ease;
}

.form-group input:focus {
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1),
                0 0 20px rgba(102, 126, 234, 0.3);
}

/* Enhanced button with ripple */
.btn-submit {
    position: relative;
    overflow: hidden;
}

.btn-submit::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-submit:active::after {
    width: 300px;
    height: 300px;
}

/* Animated header text */
.auth-card h2 {
    animation: textGlow 3s ease-in-out infinite;
}

@keyframes textGlow {
    0%, 100% {
        filter: drop-shadow(0 0 10px rgba(102, 126, 234, 0.3));
    }
    50% {
        filter: drop-shadow(0 0 20px rgba(102, 126, 234, 0.6));
    }
}

/* Floating icons */
.floating-icon {
    position: absolute;
    font-size: 40px;
    opacity: 0.1;
    animation: iconFloat 20s infinite ease-in-out;
    z-index: 1;
}

@keyframes iconFloat {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(-30px) rotate(10deg);
    }
}

/* Alert animation */
.alert {
    animation: alertSlide 0.5s ease-out;
}

@keyframes alertSlide {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Link hover effect */
.auth-footer a {
    position: relative;
    display: inline-block;
}

.auth-footer a::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: width 0.3s ease;
}

.auth-footer a:hover::before {
    width: 100%;
}

/* Shimmer effect on form */
.form-group {
    position: relative;
    overflow: hidden;
}

.form-group::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% {
        left: -100%;
    }
    100% {
        left: 100%;
    }
}
</style>
</head>
<body>
<div class="auth-container">
    <!-- Floating gradient orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    
    <!-- Floating icons -->
    <div class="floating-icon" style="top: 10%; left: 10%;">🍕</div>
    <div class="floating-icon" style="top: 80%; left: 15%; animation-delay: 3s;">🍔</div>
    <div class="floating-icon" style="top: 15%; right: 10%; animation-delay: 5s;">🍜</div>
    <div class="floating-icon" style="bottom: 15%; right: 20%; animation-delay: 7s;">🥗</div>
    
    <!-- Particles -->
    <script>
        // Generate particles dynamically
        const container = document.querySelector('.auth-container');
        for (let i = 0; i < 30; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            container.appendChild(particle);
        }
    </script>
    
    <div class="auth-card">
        <h2>Welcome Back</h2>
        <p>Sign in to your HOOSHungry account</p>
        
        <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-submit">Sign In</button>
        </form>
        
        <div class="auth-footer">
            Don't have an account? <a href="signup.php">Sign up here</a>
        </div>
    </div>
</div>

<script>
// Add smooth focus transition
document.querySelectorAll('.form-group input').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateY(-2px)';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateY(0)';
    });
});

// Enhanced button click effect
document.querySelector('.btn-submit').addEventListener('click', function(e) {
    const ripple = document.createElement('span');
    ripple.style.position = 'absolute';
    ripple.style.borderRadius = '50%';
    ripple.style.background = 'rgba(255, 255, 255, 0.6)';
    ripple.style.width = ripple.style.height = '100px';
    ripple.style.left = e.offsetX - 50 + 'px';
    ripple.style.top = e.offsetY - 50 + 'px';
    ripple.style.animation = 'ripple 0.6s ease-out';
    ripple.style.pointerEvents = 'none';
    
    this.appendChild(ripple);
    
    setTimeout(() => ripple.remove(), 600);
});

// Add ripple animation
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        from {
            transform: scale(0);
            opacity: 1;
        }
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
</body>
</html>