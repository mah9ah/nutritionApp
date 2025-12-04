<?php
require_once '../includes/db_connect.php';
require_once '../includes/session.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$username = trim($_POST['username']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
//yaqoob is testing github, please delete eventually 
// Validation
if (empty($username) || empty($password)) {
$error = 'Please fill in all required fields';
    } elseif ($password !== $confirm_password) {
$error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
$error = 'Password must be at least 6 characters';
    } else {
// Check if username exists
$check_stmt = $conn->prepare("SELECT id FROM app_user WHERE name = ?");
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$result = $check_stmt->get_result();
if ($result->num_rows > 0) {
$error = 'Username already exists';
        } else {
// Hash password and insert user
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO app_user (name, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_password);
if ($stmt->execute()) {
$_SESSION['user_id'] = $stmt->insert_id;
$_SESSION['username'] = $username;
header("Location: dashboard.php");
exit();
            } else {
$error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - HOOSHungry</title>
<link rel="stylesheet" href="../assets/styles.css">
<style>
/* Animated background effects */
.auth-container {
    position: relative;
    overflow: hidden;
}

/* Rotating gradient orbs */
.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(90px);
    opacity: 0.5;
    animation: rotateFloat 25s infinite ease-in-out;
}

.orb-1 {
    width: 450px;
    height: 450px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    top: -225px;
    left: -225px;
    animation-delay: 0s;
}

.orb-2 {
    width: 400px;
    height: 400px;
    background: linear-gradient(135deg, #f093fb, #f5576c);
    bottom: -200px;
    right: -200px;
    animation-delay: 7s;
}

.orb-3 {
    width: 350px;
    height: 350px;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    top: 40%;
    right: -175px;
    animation-delay: 14s;
}

.orb-4 {
    width: 320px;
    height: 320px;
    background: linear-gradient(135deg, #43e97b, #38f9d7);
    bottom: 20%;
    left: -160px;
    animation-delay: 21s;
}

@keyframes rotateFloat {
    0%, 100% {
        transform: translate(0, 0) rotate(0deg) scale(1);
    }
    25% {
        transform: translate(60px, -60px) rotate(90deg) scale(1.15);
    }
    50% {
        transform: translate(-40px, 40px) rotate(180deg) scale(0.85);
    }
    75% {
        transform: translate(40px, 60px) rotate(270deg) scale(1.1);
    }
}

/* Floating particle system */
.particle {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    animation: particleRise 12s infinite ease-in-out;
}

.particle-1 { background: rgba(102, 126, 234, 0.4); width: 6px; height: 6px; }
.particle-2 { background: rgba(240, 147, 251, 0.4); width: 4px; height: 4px; }
.particle-3 { background: rgba(79, 172, 254, 0.4); width: 5px; height: 5px; }

@keyframes particleRise {
    0% {
        transform: translateY(0) translateX(0) scale(0);
        opacity: 0;
    }
    10% {
        opacity: 0.6;
        transform: scale(1);
    }
    90% {
        opacity: 0.6;
    }
    100% {
        transform: translateY(-120vh) translateX(100px) scale(0);
        opacity: 0;
    }
}

/* Enhanced auth card with animated glow */
.auth-card {
    position: relative;
    z-index: 10;
    animation: cardEntrance 0.9s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.auth-card::before {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #667eea);
    background-size: 300% 300%;
    border-radius: 27px;
    opacity: 0;
    transition: opacity 0.6s ease;
    z-index: -1;
    filter: blur(25px);
    animation: gradientRotate 8s ease infinite;
}

.auth-card:hover::before {
    opacity: 0.7;
}

@keyframes gradientRotate {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

@keyframes cardEntrance {
    from {
        opacity: 0;
        transform: translateY(40px) scale(0.9) rotateX(10deg);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1) rotateX(0deg);
    }
}

/* Animated header with gradient text */
.auth-card h2 {
    animation: textGlow 4s ease-in-out infinite;
    position: relative;
}

.auth-card h2::after {
    content: '✨';
    position: absolute;
    right: -40px;
    top: 0;
    font-size: 24px;
    animation: sparkle 2s ease-in-out infinite;
}

@keyframes sparkle {
    0%, 100% {
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
    50% {
        transform: scale(1.3) rotate(180deg);
        opacity: 0.6;
    }
}

@keyframes textGlow {
    0%, 100% {
        filter: drop-shadow(0 0 15px rgba(102, 126, 234, 0.4));
    }
    50% {
        filter: drop-shadow(0 0 25px rgba(118, 75, 162, 0.6));
    }
}

/* Interactive form groups */
.form-group {
    position: relative;
    overflow: visible;
    transition: all 0.3s ease;
}

.form-group input {
    position: relative;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-group input:focus {
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1),
                0 0 30px rgba(102, 126, 234, 0.3),
                0 8px 16px rgba(0, 0, 0, 0.1);
    transform: translateY(-3px);
}

/* Password strength indicator */
.password-strength {
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    margin-top: 8px;
    overflow: hidden;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.password-strength.visible {
    opacity: 1;
}

.password-strength-bar {
    height: 100%;
    width: 0;
    transition: width 0.3s ease, background 0.3s ease;
    border-radius: 2px;
}

.password-strength-bar.weak {
    width: 33%;
    background: linear-gradient(90deg, #f5576c, #f093fb);
}

.password-strength-bar.medium {
    width: 66%;
    background: linear-gradient(90deg, #f5576c, #f093fb, #4facfe);
}

.password-strength-bar.strong {
    width: 100%;
    background: linear-gradient(90deg, #43e97b, #38f9d7);
    box-shadow: 0 0 10px rgba(67, 233, 123, 0.6);
}

/* Password match indicator */
.match-indicator {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.match-indicator.visible {
    opacity: 1;
}

/* Enhanced button with multiple effects */
.btn-submit {
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-submit::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-submit:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
}

.btn-submit:active::before {
    width: 400px;
    height: 400px;
}

/* Floating icons with different animations */
.floating-icon {
    position: absolute;
    font-size: 45px;
    opacity: 0.15;
    z-index: 1;
    animation: iconFloat 25s infinite ease-in-out;
}

.floating-icon:nth-child(odd) {
    animation: iconFloatReverse 20s infinite ease-in-out;
}

@keyframes iconFloat {
    0%, 100% {
        transform: translateY(0) rotate(0deg) scale(1);
    }
    25% {
        transform: translateY(-40px) rotate(5deg) scale(1.1);
    }
    50% {
        transform: translateY(-20px) rotate(-5deg) scale(0.9);
    }
    75% {
        transform: translateY(-35px) rotate(3deg) scale(1.05);
    }
}

@keyframes iconFloatReverse {
    0%, 100% {
        transform: translateY(0) rotate(0deg) scale(1);
    }
    25% {
        transform: translateY(-30px) rotate(-5deg) scale(0.95);
    }
    50% {
        transform: translateY(-50px) rotate(5deg) scale(1.15);
    }
    75% {
        transform: translateY(-25px) rotate(-3deg) scale(1);
    }
}

/* Alert animation */
.alert {
    animation: alertBounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes alertBounce {
    from {
        opacity: 0;
        transform: translateY(-30px) scale(0.8);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Enhanced link with gradient underline */
.auth-footer a {
    position: relative;
    display: inline-block;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
}

.auth-footer a::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 2px;
}

.auth-footer a:hover::before {
    width: 100%;
}

/* Label animation on focus */
.form-group label {
    transition: all 0.3s ease;
}

.form-group input:focus + label,
.form-group.has-content label {
    color: #667eea;
    transform: translateY(-2px);
}

/* Success checkmark animation */
@keyframes checkmark {
    0% {
        transform: scale(0) rotate(45deg);
    }
    50% {
        transform: scale(1.2) rotate(45deg);
    }
    100% {
        transform: scale(1) rotate(45deg);
    }
}

/* Progress dots for loading */
.loading-dots {
    display: none;
    text-align: center;
    margin-top: 10px;
}

.loading-dots span {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #667eea;
    margin: 0 3px;
    animation: loadingDot 1.4s infinite ease-in-out both;
}

.loading-dots span:nth-child(1) { animation-delay: -0.32s; }
.loading-dots span:nth-child(2) { animation-delay: -0.16s; }

@keyframes loadingDot {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}
</style>
</head>
<body>
<div class="auth-container">
    <!-- Floating gradient orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <div class="orb orb-4"></div>
    
    <!-- Floating food icons -->
    <div class="floating-icon" style="top: 8%; left: 8%;">🍕</div>
    <div class="floating-icon" style="top: 85%; left: 12%; animation-delay: 4s;">🍔</div>
    <div class="floating-icon" style="top: 12%; right: 8%; animation-delay: 6s;">🍜</div>
    <div class="floating-icon" style="bottom: 12%; right: 15%; animation-delay: 8s;">🥗</div>
    <div class="floating-icon" style="top: 50%; left: 5%; animation-delay: 10s;">🍰</div>
    <div class="floating-icon" style="bottom: 40%; right: 10%; animation-delay: 12s;">🌮</div>
    
    <!-- Particles -->
    <script>
        // Generate dynamic particles
        const container = document.querySelector('.auth-container');
        for (let i = 0; i < 40; i++) {
            const particle = document.createElement('div');
            const particleClass = 'particle-' + (Math.floor(Math.random() * 3) + 1);
            particle.className = 'particle ' + particleClass;
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 12 + 's';
            particle.style.animationDuration = (Math.random() * 8 + 10) + 's';
            container.appendChild(particle);
        }
    </script>
    
    <div class="auth-card">
        <h2>Create Account</h2>
        <p>Join HOOSHungry to start organizing your recipes</p>
        
        <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="" id="signupForm">
            <div class="form-group">
                <label for="username">Username *</label>
                <input type="text" id="username" name="username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required>
                <div class="password-strength">
                    <div class="password-strength-bar"></div>
                </div>
            </div>
            
            <div class="form-group" style="position: relative;">
                <label for="confirm_password">Confirm Password *</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="match-indicator"></span>
            </div>
            
            <button type="submit" class="btn-submit">Create Account</button>
            
            <div class="loading-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </form>
        
        <div class="auth-footer">
            Already have an account? <a href="signin.php">Sign in here</a>
        </div>
    </div>
</div>

<script>
// Password strength checker
const passwordInput = document.getElementById('password');
const strengthIndicator = document.querySelector('.password-strength');
const strengthBar = document.querySelector('.password-strength-bar');

passwordInput.addEventListener('input', function() {
    const password = this.value;
    strengthIndicator.classList.add('visible');
    
    if (password.length === 0) {
        strengthIndicator.classList.remove('visible');
        return;
    }
    
    let strength = 0;
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
    strengthBar.className = 'password-strength-bar';
    
    if (strength <= 2) {
        strengthBar.classList.add('weak');
    } else if (strength <= 4) {
        strengthBar.classList.add('medium');
    } else {
        strengthBar.classList.add('strong');
    }
});

// Password match indicator
const confirmPasswordInput = document.getElementById('confirm_password');
const matchIndicator = document.querySelector('.match-indicator');

function checkPasswordMatch() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    
    if (confirmPassword.length === 0) {
        matchIndicator.classList.remove('visible');
        return;
    }
    
    matchIndicator.classList.add('visible');
    
    if (password === confirmPassword && confirmPassword.length > 0) {
        matchIndicator.textContent = '✓';
        matchIndicator.style.color = '#43e97b';
    } else {
        matchIndicator.textContent = '✗';
        matchIndicator.style.color = '#f5576c';
    }
}

passwordInput.addEventListener('input', checkPasswordMatch);
confirmPasswordInput.addEventListener('input', checkPasswordMatch);

// Smooth focus transitions
document.querySelectorAll('.form-group input').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'translateY(-3px)';
        this.parentElement.style.transition = 'transform 0.3s ease';
    });
    
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'translateY(0)';
    });
});

// Enhanced button click ripple effect
document.querySelector('.btn-submit').addEventListener('click', function(e) {
    const ripple = document.createElement('span');
    const rect = this.getBoundingClientRect();
    ripple.style.position = 'absolute';
    ripple.style.borderRadius = '50%';
    ripple.style.background = 'rgba(255, 255, 255, 0.7)';
    ripple.style.width = ripple.style.height = '120px';
    ripple.style.left = e.clientX - rect.left - 60 + 'px';
    ripple.style.top = e.clientY - rect.top - 60 + 'px';
    ripple.style.animation = 'ripple 0.8s ease-out';
    ripple.style.pointerEvents = 'none';
    
    this.appendChild(ripple);
    
    setTimeout(() => ripple.remove(), 800);
});

// Form submission animation
document.getElementById('signupForm').addEventListener('submit', function(e) {
    const loadingDots = document.querySelector('.loading-dots');
    loadingDots.style.display = 'block';
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
            transform: scale(5);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Input validation visual feedback
document.querySelectorAll('.form-group input').forEach(input => {
    input.addEventListener('invalid', function(e) {
        e.preventDefault();
        this.style.animation = 'shake 0.5s';
        setTimeout(() => {
            this.style.animation = '';
        }, 500);
    });
});

// Shake animation for invalid inputs
const shakeStyle = document.createElement('style');
shakeStyle.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
`;
document.head.appendChild(shakeStyle);
</script>
</body>
</html>