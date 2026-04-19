<?php 
require_once 'config/db.php'; 
include 'includes/header.php'; 


if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
$stmt->execute([$_GET['id']]);
$tour = $stmt->fetch();

if (!$tour) {
    echo "<h1>Тур не найден</h1>";
    include 'includes/footer.php';
    exit;
}
?>

<div class="tour-detail-container" style="display: flex; gap: 40px; margin-top: 30px;">
    
    <div style="flex: 2;">
        <div style="position: relative; border-radius: 30px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1);">
            <img src="assets/img/tours/<?= $tour['image_url'] ?>" style="width: 100%; height: 500px; object-fit: cover;">
            <div style="position: absolute; top: 20px; left: 20px; background: rgba(255,255,255,0.9); padding: 10px 20px; border-radius: 50px; font-weight: bold; color: var(--secondary);">
                <?= str_repeat('★', $tour['stars']) ?> Отель <?= $tour['stars'] ?>*
            </div>
        </div>

        <h1 style="font-size: 2.5em; margin-top: 30px;"><?= htmlspecialchars($tour['hotel_name']) ?></h1>
        <p style="color: #636e72; font-size: 1.1em; line-height: 1.8; margin-bottom: 40px;">
            <?= nl2br(htmlspecialchars($tour['description'])) ?>
        </p>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px;">
            <div style="background: white; padding: 20px; border-radius: 20px; text-align: center; border: 1px solid #eee;">
                <i class="fas fa-utensils" style="font-size: 1.5em; color: var(--secondary);"></i>
                <p style="margin-top: 10px; font-weight: 600;">Все включено</p>
            </div>
            <div style="background: white; padding: 20px; border-radius: 20px; text-align: center; border: 1px solid #eee;">
                <i class="fas fa-swimming-pool" style="font-size: 1.5em; color: var(--secondary);"></i>
                <p style="margin-top: 10px; font-weight: 600;">Бассейн</p>
            </div>
            <div style="background: white; padding: 20px; border-radius: 20px; text-align: center; border: 1px solid #eee;">
                <i class="fas fa-wifi" style="font-size: 1.5em; color: var(--secondary);"></i>
                <p style="margin-top: 10px; font-weight: 600;">Free Wi-Fi</p>
            </div>
        </div>
    </div>

    <div style="flex: 1; position: sticky; top: 100px; height: fit-content;">
        <div style="background: white; padding: 30px; border-radius: 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.08); border: 1px solid #f0f0f0;">
            <h3 style="margin-bottom: 10px;">Забронировать отдых</h3>
            <div style="font-size: 2em; font-weight: 700; color: var(--secondary); margin-bottom: 20px;">
                <?= number_format($tour['price_per_night'], 0, '.', ' ') ?> ₽ <small style="font-size: 0.4em; color: #aaa; font-weight: 400;">/ за ночь</small>
            </div>

            <form action="process_booking.php" method="POST">
                <input type="hidden" name="tour_id" value="<?= $tour['id'] ?>">
                
                <label style="font-size: 0.8em; font-weight: 600; color: #999;">КОЛИЧЕСТВО ГОСТЕЙ</label>
                <select name="persons" style="background: #f9f9f9;">
                    <option value="1">1 человек</option>
                    <option value="2" selected>2 человека</option>
                    <option value="3">3 человека</option>
                    <option value="4">4 человека</option>
                </select>

                <label style="font-size: 0.8em; font-weight: 600; color: #999;">КОЛИЧЕСТВО НОЧЕЙ</label>
                <input type="number" name="nights" value="7" min="1" max="30" style= "width: 92% ; background: #f9f9f9;">

                <div style="background: #eef2f7; padding: 15px; border-radius: 15px; margin: 20px 0;">
                    <div style="display: flex; justify-content: space-between; font-weight: 600;">
                        <span>Итоговая цена:</span>
                        <span id="total-price-display" style="color: var(--secondary);">Рассчитываем...</span>
                    </div>
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <button type="submit" class="btn" style="width: 100%; padding: 15px; font-size: 1.1em;">Забронировать тур</button>
                <?php else: ?>
                    <a href="login.php" class="btn" style="width: 86%; text-align: center; background: #636e72;">Войдите, чтобы купить</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<script>
    const pricePerNight = <?= $tour['price_per_night'] ?>;
    const nightsInput = document.querySelector('input[name="nights"]');
    const personsInput = document.querySelector('select[name="persons"]');
    const display = document.getElementById('total-price-display');

    function updatePrice() {
        const total = pricePerNight * nightsInput.value * (1 + (personsInput.value - 1) * 0.5); // +50% за каждого доп. человека
        display.innerText = new Intl.NumberFormat('ru-RU').format(total) + ' ₽';
    }

    nightsInput.addEventListener('input', updatePrice);
    personsInput.addEventListener('change', updatePrice);
    updatePrice(); // Первый запуск
</script>

<?php include 'includes/footer.php'; ?>