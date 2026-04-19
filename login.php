<?php 
require_once 'config/db.php';
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

   if ($user && password_verify($password, $user['password_hash'])) {
    session_start();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    header("Location: profile.php");
    exit;
}
    } else {
        $error = "Неверный логин или пароль!";
    }

?>

<?php include 'includes/header.php'; ?>
<h2>Вход в систему</h2>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Логин" required><br><br>
    <input type="password" name="password" placeholder="Пароль" required><br><br>
    <button type="submit">Войти</button>
</form>
<?php include 'includes/footer.php'; ?>