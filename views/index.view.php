<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Sueta.ru</title>
    <link rel="stylesheet" href="models/main.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🚗 Sueta.ru</div>
            <div style="display: flex; gap: 10px;">
                <?php if ($isAdmin): ?>
                    <span style="background: #ff6b00; color: white; padding: 8px 16px; border-radius: 30px;">👑 Админ</span>
                    <a href="controller/logout.php" class="btn-add" style="background: #dc3545;">Выйти</a>
                <?php elseif ($isLoggedIn): ?>
                    <span style="background: #28a745; color: white; padding: 8px 16px; border-radius: 30px;">👤 <?= htmlspecialchars($currentUser['email']) ?></span>
                    <a href="controller/logout.php" class="btn-add" style="background: #dc3545;">Выйти</a>
                <?php else: ?>
                    <a href="controller/login.php" class="btn-add" style="background: #28a745;">Войти</a>
                    <a href="controller/register.php" class="btn-add">Регистрация</a>
                <?php endif; ?>
                <a href="controller/add_ad.php" class="btn-add">+ Добавить</a>
            </div>
        </div>

        
        <div class="filter-box">
            <h3>🔍 Подобрать автомобиль</h3>
            <form method="GET" action="/index.php">
                <div class="filter-row">
                    <div class="filter-group">
                        <label>Марка</label>
                        <select name="brand_id">
                            <option value="">Все марки</option>
                            <?php foreach ($brands as $brand): ?>
                                <option value="<?= $brand['id'] ?>" <?= (isset($_GET['brand_id']) && $_GET['brand_id'] == $brand['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($brand['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="filter-group">
                        <label>Модель</label>
                        <select name="model_id">
                            <option value="">Все модели</option>
                            <?php foreach ($allModels as $model): ?>
                                <?php 
                                $showModel = true;
                                if (!empty($_GET['brand_id']) && $_GET['brand_id'] != $model['brand_id']) {
                                    $showModel = false;
                                }
                                ?>
                                <?php if ($showModel): ?>
                                    <option value="<?= $model['id'] ?>" <?= (isset($_GET['model_id']) && $_GET['model_id'] == $model['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($model['name']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">🔎 Найти</button>
                        <a href="/index.php" class="btn-reset">Сбросить</a>
                    </div>
                </div>
            </form>
        </div>
        

        <div class="cards">
            <?php foreach ($ads as $ad): ?>
                <div class="card">
                    <div class="card-photo">
                        <?php if ($ad['photo_path'] && file_exists($ad['photo_path'])): ?>
                        <img src="/<?= htmlspecialchars($ad['photo_path']) ?>" alt="Фото" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            📸
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="car-name">
                            <?= htmlspecialchars($ad['add_name']) ?><br>
                            <?= htmlspecialchars($ad['brand_name']) ?> <?= htmlspecialchars($ad['model_name']) ?>
                        </div>
                        <div class="price"><?= number_format($ad['price']) ?> ₽</div>
                        <div class="specs">
                            <?= $ad['years'] ?> г. • <?= number_format($ad['mileage']) ?> км • <?= $ad['engine_volume'] ?> л • <?= $ad['power_hp'] ?> л.с.
                        </div>
                        <div class="desc"><strong style="color: black;">описание:</strong> <?= htmlspecialchars($ad['description'])?></div>
                        <div class="actions">
                            <a href="controller/view.php?id=<?= $ad['id'] ?>" class="btn">Просмотр</a>
                            <?php if ($isAdmin): ?>
                                <a href="controller/edit.php?id=<?= $ad['id'] ?>" class="btn" style="background: #28a745;">✏️ Ред.</a>
                                <a href="controller/delete.php?id=<?= $ad['id'] ?>" class="btn" style="background: #6c757d;" onclick="return confirm('Удалить объявление?')">Удалить</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    
    <div class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-logo">
                    🚗 Sueta.ru
                </div>
                <div class="footer-links">
                    <a href="#">О проекте</a>
                    <a href="#">Пользовательское соглашение</a>
                    <a href="#">Политика конфиденциальности</a>
                    <a href="#">Контакты</a>
                </div>
            </div>
            <div class="footer-copyright">
                <div style="margin-top: 20px;">
                    <a href="#" onclick="alert('Свяжетесь с нами по почте: Admin@test.ru, если у вас есть вопросы по объявлениям или вы хотите изменить или удалить своё объявление'); return false;" style="display: inline-block; background: #ff6b00; color: white; padding: 10px 25px; border-radius: 40px; text-decoration: none; font-weight: bold;">
                        📞 Связаться с дилером
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>