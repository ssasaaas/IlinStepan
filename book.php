<?php
require_once 'config/db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    die("Чтобы купить тур, нужно <a href='login.php'>войти в аккаунт</a>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $tour_id = $_POST['tour_id'];
    $nights = $_POST['nights'];
    $persons = $_POST['persons'];
    

    $stmt = $pdo->prepare("SELECT price_per_night FROM tours WHERE id = ?");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch();
    
    if ($tour) {
        $total_price = $tour['price_per_night'] * $nights * $persons;


        $sql = "INSERT INTO bookings (user_id, tour_id, nights, persons, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $tour_id, $nights, $persons, $total_price]);

        echo "<h1>Успешно!</h1>";
        echo "<p>Тур забронирован. Итого к оплате: $total_price руб.</p>";
        echo "<a href='profile.php'>Перейти в мои заказы</a>";
    }
}
?>