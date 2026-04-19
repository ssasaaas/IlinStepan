<?php
require_once 'config/db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $tour_id = $_POST['tour_id'];
    $persons = (int)$_POST['persons'];
    $nights = (int)$_POST['nights'];


    $stmt = $pdo->prepare("SELECT price_per_night FROM tours WHERE id = ?");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch();

    if ($tour) {

        $total_price = $tour['price_per_night'] * $nights * (1 + ($persons - 1) * 0.5);


        $insert = $pdo->prepare("
            INSERT INTO bookings (user_id, tour_id, persons, nights, total_price, status, booking_date) 
            VALUES (?, ?, ?, ?, ?, 'pending', NOW())
        ");
        
        if ($insert->execute([$user_id, $tour_id, $persons, $nights, $total_price])) {
   
            header("Location: profile.php?success=1");
            exit;
        } else {
            echo "Ошибка при бронировании.";
        }
    }
} else {
    header("Location: index.php");
}