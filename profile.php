<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("
    SELECT b.*, t.hotel_name, t.image_url, t.stars 
    FROM bookings b 
    JOIN tours t ON b.tour_id = t.id 
    WHERE b.user_id = ? 
    ORDER BY b.booking_date DESC
");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="content-limit" style="margin-top: 40px; margin-bottom: 80px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <div>
            <h1 style="margin: 0; font-size: 2em; color: #2d3436;">
                <i class="fas fa-user-circle" style="color: var(--secondary); margin-right: 15px;"></i>
                Привет, <?= htmlspecialchars($_SESSION['username']) ?>!
            </h1>
            <p style="color: #636e72; margin: 10px 0 0;">Добро пожаловать в ваш личный кабинет путешественника.</p>
        </div>
        <div>
            <span style="padding: 10px 20px; background: #f1f2f6; border-radius: 12px; font-weight: 600; color: #57606f;">
                <i class="fas fa-id-badge"></i> Статус: <?= $_SESSION['role'] === 'admin' ? 'Администратор' : 'Клиент' ?>
            </span>
        </div>
    </div>

    <div class="booking-section">
        <h2 style="margin-bottom: 25px; font-size: 1.8em; color: #2d3436;">
            <i class="fas fa-suitcase-rolling" style="margin-right: 10px; color: var(--secondary);"></i> 
            Мои бронирования
        </h2>

        <?php if (empty($bookings)): ?>
            <div style="text-align: center; padding: 60px; background: white; border-radius: 30px; border: 2px dashed #eee;">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" style="width: 100px; opacity: 0.3; margin-bottom: 20px;">
                <h3 style="color: #636e72;">Список пуст</h3>
                <p style="color: #b2bec3;">Вы еще не забронировали ни одного приключения.</p>
                <a href="index.php" class="btn" style="margin-top: 20px; padding: 15px 40px;">Найти лучший тур</a>
            </div>
        <?php else: ?>
            <div style="display: grid; gap: 20px;">
                <?php foreach ($bookings as $b): ?>
                    <div class="booking-card" style="background: white; padding: 25px; border-radius: 25px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 8px 25px rgba(0,0,0,0.04); border: 1px solid #f8f9fa; transition: 0.3s;">
                        
                        <div style="display: flex; align-items: center; gap: 25px;">
                            <div style="position: relative;">
                                <img src="assets/img/tours/<?= $b['image_url'] ?>" style="width: 150px; height: 100px; object-fit: cover; border-radius: 18px;">
                                <div style="position: absolute; bottom: -5px; right: -5px; background: white; padding: 2px 8px; border-radius: 8px; font-size: 0.7em; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                    <?= str_repeat('★', $b['stars']) ?>
                                </div>
                            </div>
                            
                            <div>
                                <h4 style="margin: 0 0 8px; font-size: 1.3em; color: #2d3436;"><?= htmlspecialchars($b['hotel_name']) ?></h4>
                                <div style="display: flex; gap: 15px; color: #636e72; font-size: 0.9em;">
                                    <span><i class="far fa-calendar-alt" style="color: var(--secondary);"></i> <?= $b['nights'] ?> ночей</span>
                                    <span><i class="fas fa-users" style="color: var(--secondary);"></i> <?= $b['persons'] ?> чел.</span>
                                </div>
                                <p style="margin: 8px 0 0; font-size: 0.8em; color: #b2bec3;">
                                    Дата заказа: <?= date('d.m.Y', strtotime($b['booking_date'])) ?>
                                </p>
                            </div>
                        </div>

                        <div style="text-align: right; min-width: 180px;">
                            <div style="font-weight: 800; font-size: 1.5em; color: var(--secondary); margin-bottom: 10px;">
                                <?= number_format($b['total_price'], 0, '.', ' ') ?> ₽
                            </div>
                            
                            <?php 
                               
                                $statusColor = ($b['status'] === 'paid') ? '#00b894' : '#fdcb6e';
                                $statusBg = ($b['status'] === 'paid') ? '#e8f8f5' : '#fff9e6';
                                $statusText = ($b['status'] === 'paid') ? 'Оплачено' : 'Ожидает оплаты';
                            ?>
                            
                            <span style="
                                display: inline-block;
                                padding: 8px 20px; 
                                border-radius: 50px; 
                                font-size: 0.85em; 
                                font-weight: 700;
                                background: <?= $statusBg ?>; 
                                color: <?= $statusColor ?>;
                                border: 1px solid <?= $statusColor ?>33;
                            ">
                                <i class="fas <?= $b['status'] === 'paid' ? 'fa-check-circle' : 'fa-clock' ?>"></i> 
                                <?= $statusText ?>
                            </span>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>

    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08) !important;
        border-color: var(--secondary) !important;
    }
</style>

<?php include 'includes/footer.php'; ?>