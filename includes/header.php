<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SunTravel — Твой гид в мире приключений</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header id="main-header">
        <nav>
            <a href="index.php" class="logo">
                <i class="fas fa-sun"></i> SunTravel
            </a>
            
           <div class="nav-links">
    <a href="index.php">Главная</a>
    <a href="index.php#catalog">Туры</a>
    <a href="contacts.php">Контакты</a> 
</div>
            
            <div class="auth-buttons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="admin.php" title="Панель администратора" style="color: #f1c40f; font-size: 1.2em;">
                            <i class="fas fa-user-shield"></i>
                        </a>
                    <?php endif; ?>
                    
                    <a href="profile.php" class="profile-link">
                        <i class="fas fa-user-circle"></i>
                        <span><?= htmlspecialchars($_SESSION['username']) ?></span>
                    </a>
                    
                    <a href="logout.php" title="Выйти" style="color: #ff7675; font-size: 1.1em;">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                <?php else: ?>
                    <a href="login.php" style="color: #2d3436; font-weight: 600;">Вход</a>
                    <a href="register.php" class="btn" style="padding: 10px 25px; border-radius: 50px; font-size: 0.9em;">Регистрация</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <script>
        window.addEventListener('scroll', function() {
            const header = document.getElementById('main-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>

    <div class="container"> 

