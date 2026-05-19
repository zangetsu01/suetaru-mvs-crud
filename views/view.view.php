<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($ad['name']) ?></title>
    <link rel="stylesheet" href="../models/main.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🚗 Sueta.ru</div>
            <a href="/index.php" class="btn-add">← На главную</a>
        </div>

        <div class="view-container">
<div class="view-photo">
    <?php 
    $photoUrl = getPhotoUrl($ad['photo_path'] ?? null);
    if ($photoUrl): 
    ?>
        <img src="<?= htmlspecialchars($photoUrl) ?>" alt="Фото автомобиля">
    <?php else: ?>
        <div class="no-photo">📸</div>
    <?php endif; ?>
</div>
            
            
            <div class="view-content">
                <div class="view-price"><?= number_format($ad['price']) ?> ₽</div>
                
                <div class="view-specs">
                    <div>
                        <div class="spec-label">Марка и модель</div>
                        <div class="spec-value"><?= $ad['brand_name'] ?> <?= $ad['model_name'] ?></div>
                    </div>
                    <div>
                        <div class="spec-label">Год выпуска</div>
                        <div class="spec-value"><?= $ad['years'] ?> г.</div>
                    </div>
                    <div>
                        <div class="spec-label">Пробег</div>
                        <div class="spec-value"><?= number_format($ad['mileage']) ?> км</div>
                    </div>
                    <div>
                        <div class="spec-label">Двигатель</div>
                        <div class="spec-value"><?= $ad['engine_volume'] ?> л / <?= $ad['power_hp'] ?> л.с.</div>
                    </div>
                    <div>
                        <div class="spec-label">Цвет</div>
                        <div class="spec-value"><?= $ad['color'] ?></div>
                    </div>
                    <div>
                        <div class="spec-label">📧 Связь с продавцом</div>
                        <div class="spec-value"><?= htmlspecialchars($ad['user_email'] ?? 'Email не указан') ?></div>
                    </div>
                </div>
                
                <div class="view-desc">
                    <h3>📝 Описание</h3>
                    <p><?= nl2br(htmlspecialchars($ad['description'])) ?></p>
                </div>
                
                <div class="view-actions">
                    <a href="/index.php" class="btn-back">← Назад</a>
                    <?php if ($isAdmin): ?>
    <a href="edit.php?id=<?= $ad['id'] ?>" class="btn-edit">✏️ Редактировать</a>
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>