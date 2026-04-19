<?php 
require_once 'config/db.php'; 
include 'includes/header.php'; 
?>

<div class="content-limit" style="margin-top: 50px; margin-bottom: 80px;">
    
    <div style="text-align: center; margin-bottom: 60px;">
        <h1 style="font-size: 3em; color: #2d3436; margin-bottom: 15px;">Свяжитесь с нами</h1>
        <p style="color: #636e72; font-size: 1.2em; max-width: 600px; margin: 0 auto;">
            Мы на связи 24/7, чтобы помочь вам спланировать идеальное путешествие. Заходите в гости или пишите в мессенджеры!
        </p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 50px;">
        
        <div>
            <div style="background: white; padding: 40px; border-radius: 30px; box-shadow: 0 15px 40px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">
                
                <div style="margin-bottom: 35px; display: flex; gap: 20px; align-items: flex-start;">
                    <div style="width: 50px; height: 50px; background: #ebf3ff; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: var(--secondary); flex-shrink: 0;">
                        <i class="fas fa-map-marker-alt" style="font-size: 1.5em;"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 5px; font-size: 1.1em;">Наш офис</h4>
                        <p style="color: #636e72; margin: 0; line-height: 1.5;">г. Уфа, ул. Пушкина, д. 10,<br>БЦ "Океан", офис 404</p>
                    </div>
                </div>

                <div style="margin-bottom: 35px; display: flex; gap: 20px; align-items: flex-start;">
                    <div style="width: 50px; height: 50px; background: #e8f8f5; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: #27ae60; flex-shrink: 0;">
                        <i class="fas fa-phone-alt" style="font-size: 1.5em;"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 5px; font-size: 1.1em;">Телефон</h4>
                        <p style="color: #636e72; margin: 0; line-height: 1.5; font-weight: 600;">8 (800) 555-35-35</p>
                        <small style="color: #b2bec3;">Бесплатно по всей России</small>
                    </div>
                </div>

                <div style="margin-bottom: 35px; display: flex; gap: 20px; align-items: flex-start;">
                    <div style="width: 50px; height: 50px; background: #fff1f1; border-radius: 15px; display: flex; align-items: center; justify-content: center; color: #ff7675; flex-shrink: 0;">
                        <i class="fas fa-envelope" style="font-size: 1.5em;"></i>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 5px; font-size: 1.1em;">E-mail</h4>
                        <p style="color: #636e72; margin: 0; line-height: 1.5;">hello@suntravel.ru</p>
                    </div>
                </div>

                <hr style="border: 0; height: 1px; background: #eee; margin: 30px 0;">

                <h4 style="margin-bottom: 20px;">Мы в соцсетях:</h4>
                <div style="display: flex; gap: 15px;">
                    <a href="#" style="width: 45px; height: 45px; background: #0088cc; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s;"><i class="fab fa-telegram-plane"></i></a>
                    <a href="#" style="width: 45px; height: 45px; background: #4c75a3; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s;"><i class="fab fa-vk"></i></a>
                    <a href="#" style="width: 45px; height: 45px; background: #25d366; color: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s;"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 30px;">
            <div style="width: 100%; height: 300px; background: #eee; border-radius: 30px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                <img src="https://static-maps.yandex.ru/1.x/?ll=37.622504,55.753215&spn=0.01,0.01&l=map&size=600,300" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <div style="background: white; padding: 40px; border-radius: 30px; box-shadow: 0 15px 40px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">
                <h3 style="margin-top: 0; margin-bottom: 25px;">Напишите нам</h3>
                <form action="send_message.php" method="POST">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <input type="text" name="name" placeholder="Ваше имя" required style="width: 95%; background: #f9f9f9; border: 1px solid #eee;">
                        <input type="email" name="email" placeholder="E-mail" required style="width: 95%; background: #f9f9f9; border: 1px solid #eee;">
                    </div>
                    <textarea name="message" rows="5" placeholder="Ваш вопрос или пожелание..." style="width: 98%; background: #f9f9f9; border: 1px solid #eee; margin-bottom: 20px;"></textarea>
                    <button type="submit" class="btn" style="width: 100%; padding: 15px;">Отправить сообщение</button>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>