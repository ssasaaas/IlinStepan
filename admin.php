<?php
require_once 'config/db.php';
if (session_status() === PHP_SESSION_NONE) session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}


if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM tours WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header("Location: admin.php#tours_table");
    exit;
}


if (isset($_GET['approve_booking'])) {
    $stmt = $pdo->prepare("UPDATE bookings SET status = 'paid' WHERE id = ?");
    $stmt->execute([$_GET['approve_booking']]);
    header("Location: admin.php#bookings_table");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hotel = $_POST['hotel_name'];
    $price = $_POST['price'];
    $stars = $_POST['stars'];
    $desc = $_POST['description'];
    $country_id = $_POST['country_id'];

    if (!empty($_FILES['tour_image']['name'])) {
        $img_name = time() . '_' . $_FILES['tour_image']['name'];
        move_uploaded_file($_FILES['tour_image']['tmp_name'], 'assets/img/tours/' . $img_name);
    } else {
        $img_name = $_POST['old_image'] ?? 'default.jpg';
    }

    if (isset($_POST['edit_id'])) {
        $sql = "UPDATE tours SET country_id=?, hotel_name=?, description=?, price_per_night=?, stars=?, image_url=? WHERE id=?";
        $pdo->prepare($sql)->execute([$country_id, $hotel, $desc, $price, $stars, $img_name, $_POST['edit_id']]);
    } else {
        $sql = "INSERT INTO tours (country_id, hotel_name, description, price_per_night, stars, image_url) VALUES (?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$country_id, $hotel, $desc, $price, $stars, $img_name]);
    }
    header("Location: admin.php");
    exit;
}

$edit_tour = null;
if (isset($_GET['edit_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
    $stmt->execute([$_GET['edit_id']]);
    $edit_tour = $stmt->fetch();
}

include 'includes/header.php';
?>

<div class="content-limit" style="margin-top: 30px;">
    <h1 style="margin-bottom: 30px; display: flex; align-items: center; gap: 15px;">
        <i class="fas fa-tools" style="color: var(--secondary);"></i> Панель администратора
    </h1>

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px; align-items: start;">
        
        <section style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); position: sticky; top: 100px;">
            <h3 style="margin-top: 0;"><?= $edit_tour ? "✨ Редактировать" : "➕ Добавить тур" ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <?php if ($edit_tour): ?>
                    <input type="hidden" name="edit_id" value="<?= $edit_tour['id'] ?>">
                    <input type="hidden" name="old_image" value="<?= $edit_tour['image_url'] ?>">
                <?php endif; ?>

                <label style="font-size: 0.8em; font-weight: 600; color: #aaa;">НАЗВАНИЕ ОТЕЛЯ</label>
                <input type="text" name="hotel_name" style="width: 93%;" value="<?= $edit_tour['hotel_name'] ?? '' ?>" required>
                
                <label style="font-size: 0.8em; font-weight: 600; color: #aaa;">СТРАНА</label>
                <select name="country_id">
                    <option value="1" <?= (isset($edit_tour) && $edit_tour['country_id'] == 1) ? 'selected' : '' ?>>Турция</option>
                    <option value="2" <?= (isset($edit_tour) && $edit_tour['country_id'] == 2) ? 'selected' : '' ?>>Египет</option>
                    <option value="3" <?= (isset($edit_tour) && $edit_tour['country_id'] == 3) ? 'selected' : '' ?>>ОАЭ</option>
                </select>

                <div style="display: flex; gap: 15px;">
                    <div style="flex: 1;">
                        <label style="font-size: 0.8em; font-weight: 600; color: #aaa;">ЦЕНА/НОЧЬ</label>
                        <input type="number" name="price" style="width: 85%;" value="<?= $edit_tour['price_per_night'] ?? '' ?>" required>
                    </div>
                    <div style="flex: 1;">
                        <label style="font-size: 0.8em; font-weight: 600; color: #aaa;">ЗВЕЗДЫ</label>
                        <input type="number" name="stars" min="1" max="5" style="width: 85%";"value="<?= $edit_tour['stars'] ?? 5 ?>">
                    </div>
                </div>

                <label style="font-size: 0.8em; font-weight: 600; color: #aaa;">ОПИСАНИЕ</label>
                <textarea name="description" rows="4" style="width: 92%"><?= $edit_tour['description'] ?? '' ?></textarea>

                <label style="font-size: 0.8em; font-weight: 600; color: #aaa;">ФОТОГРАФИЯ</label>
                <?php if ($edit_tour): ?>
                    <img src="assets/img/tours/<?= $edit_tour['image_url'] ?>" style="width: 100%; height: 100px; object-fit: cover; border-radius: 10px; margin: 10px 0;">
                <?php endif; ?>
                <input type="file" name="tour_image" style="padding: 10px 0; border: none;">

                <button type="submit" class="btn" style="width: 100%; margin-top: 10px;">
                    <?= $edit_tour ? "Сохранить изменения" : "Опубликовать тур" ?>
                </button>
                
                <?php if ($edit_tour): ?>
                    <a href="admin.php" style="display: block; text-align: center; margin-top: 15px; color: #636e72; text-decoration: none; font-size: 0.9em;">Отмена</a>
                <?php endif; ?>
            </form>
        </section>

        <div style="display: flex; flex-direction: column; gap: 40px;">
            
            <section id="bookings_table" style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <h3 style="margin-top: 0; margin-bottom: 20px;"><i class="fas fa-shopping-cart"></i> Последние заказы</h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 2px solid #f9f9f9; color: #aaa; font-size: 0.8em;">
                                <th style="padding: 10px;">ID</th>
                                <th style="padding: 10px;">ТУР</th>
                                <th style="padding: 10px;">ЦЕНА</th>
                                <th style="padding: 10px;">СТАТУС</th>
                                <th style="padding: 10px;">ДЕЙСТВИЕ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $bookings = $pdo->query("SELECT b.*, t.hotel_name FROM bookings b JOIN tours t ON b.tour_id = t.id ORDER BY b.id DESC LIMIT 10")->fetchAll();
                            foreach ($bookings as $b):
                            ?>
                            <tr style="border-bottom: 1px solid #f9f9f9; font-size: 0.9em;">
                                <td style="padding: 15px;"><?= $b['id'] ?></td>
                                <td style="padding: 15px; font-weight: 600;"><?= $b['hotel_name'] ?></td>
                                <td style="padding: 15px; color: var(--secondary); font-weight: bold;"><?= number_format($b['total_price'], 0, '.', ' ') ?> ₽</td>
                                <td style="padding: 15px;">
                                    <span style="padding: 4px 10px; border-radius: 50px; font-size: 0.8em; background: <?= $b['status'] === 'paid' ? '#e8f8f5; color: #27ae60;' : '#fff9e6; color: #f39c12;' ?>">
                                        <?= $b['status'] === 'paid' ? 'Оплачено' : 'Ожидание' ?>
                                    </span>
                                </td>
                                <td style="padding: 15px;">
                                    <?php if ($b['status'] !== 'paid'): ?>
                                        <a href="admin.php?approve_booking=<?= $b['id'] ?>" style="color: #27ae60; text-decoration: none;"><i class="fas fa-check-circle"></i> Подтвердить</a>
                                    <?php else: ?>
                                        <span style="color: #aaa;"><i class="fas fa-check"></i> Готово</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="tours_table" style="background: white; padding: 30px; border-radius: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <h3 style="margin-top: 0; margin-bottom: 20px;"><i class="fas fa-palmtree"></i> Все туры</h3>
                <div style="display: grid; gap: 15px;">
                    <?php 
                    $tours = $pdo->query("SELECT * FROM tours ORDER BY id DESC")->fetchAll();
                    foreach ($tours as $t): 
                    ?>
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 15px; background: #fdfdfd; border-radius: 15px; border: 1px solid #f1f1f1;">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <img src="assets/img/tours/<?= $t['image_url'] ?>" style="width: 60px; height: 45px; object-fit: cover; border-radius: 8px;">
                            <div>
                                <h4 style="margin: 0; font-size: 1em;"><?= $t['hotel_name'] ?></h4>
                                <small style="color: #aaa;"><?= $t['price_per_night'] ?> ₽ / ночь</small>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <a href="admin.php?edit_id=<?= $t['id'] ?>" style="padding: 8px; color: var(--secondary); background: #ebf3ff; border-radius: 8px; text-decoration: none;"><i class="fas fa-edit"></i></a>
                            <a href="admin.php?delete_id=<?= $t['id'] ?>" onclick="return confirm('Удалить этот тур?')" style="padding: 8px; color: #ff7675; background: #fff1f1; border-radius: 8px; text-decoration: none;"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>