<?php 
require_once 'config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user, $email, $pass]);

    echo "Регистрация успешна! <a href='login.php'>Войти</a>";
}
?>

<?php include 'includes/header.php'; ?>
<h2>Регистрация</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Логин" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Пароль" required><br><br>
    <button type="submit">Зарегистрироваться</button>
</form>
<?php include 'includes/footer.php'; ?>