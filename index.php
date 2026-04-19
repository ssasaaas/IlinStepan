<?php 
require_once 'config/db.php'; 
include 'includes/header.php'; 
$tours = $pdo->query("SELECT * FROM tours")->fetchAll();
?>

<div class="hero-section" style="
    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1600');
    background-size: cover;
    background-position: center;
    height: 600px;
    border-radius: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: white;
    text-align: center;
    position: relative;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
">
    <h1 style="font-size: 4.5em; margin: 0; font-weight: 700; text-transform: uppercase; letter-spacing: 3px;">Ваше приключение начинается здесь</h1>
    <p style="font-size: 1.5em; margin: 20px 0 40px; opacity: 0.9;">Оставьте суету города и доверьте свой отдых профессионалам</p>
    <a href="#catalog" class="btn" style="padding: 20px 60px; font-size: 1.2em; border-radius: 50px; box-shadow: 0 10px 20px rgba(0,0,0,0.3);">Найти тур мечты</a>
</div>

<div style="padding: 80px 0; text-align: center; max-width: 900px; margin: 0 auto;">
    <h2 style="font-size: 2.5em; color: #2d3436; margin-bottom: 20px;">Забудьте о границах</h2>
    <p style="font-size: 1.2em; color: #636e72; line-height: 1.8; font-style: italic;">
        "Путешествие в тысячу миль начинается с первого шага. Мы позаботились о том, чтобы каждый ваш шаг был наполнен комфортом, безопасностью и невероятными эмоциями. От белоснежных пляжей Мальдив до величественных гор Кавказа — мир гораздо ближе, чем вы думаете."
    </p>
    
    <div style="display: flex; justify-content: space-around; margin-top: 50px;">
        <div>
            <i class="fas fa-shield-alt" style="font-size: 2em; color: #3a7bd5;"></i>
            <p style="font-weight: 600; margin-top: 10px;">100% Безопасность</p>
        </div>
        <div>
            <i class="fas fa-headset" style="font-size: 2em; color: #3a7bd5;"></i>
            <p style="font-weight: 600; margin-top: 10px;">Поддержка 24/7</p>
        </div>
        <div>
            <i class="fas fa-star" style="font-size: 2em; color: #3a7bd5;"></i>
            <p style="font-weight: 600; margin-top: 10px;">Лучшие отели</p>
        </div>
    </div>
</div>

<hr style="border: 0; height: 1px; background: #eee; margin-bottom: 60px;">

<h2 id="catalog" style="text-align: center; margin-bottom: 50px; font-size: 2em;">🌟 Наши лучшие предложения</h2>

<div class="tour-grid">
    <?php foreach ($tours as $tour): ?>
        <div class="tour-card">
            <img src="assets/img/tours/<?= $tour['image_url'] ?>" alt="tour">
            <div class="card-body">
                <div class="stars"><?= str_repeat('★', $tour['stars']) ?></div>
                <h4 style="margin: 10px 0; font-size: 1.1em;"><?= $tour['hotel_name'] ?></h4>
                <div class="price-tag" style="font-size: 1.2em;"><?= number_format($tour['price_per_night'], 0, '.', ' ') ?> ₽</div>
                <a href="tour_details.php?id=<?= $tour['id'] ?>" class="btn" style="width: 100%; padding: 10px 0; font-size: 0.9em;">Подробнее</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>